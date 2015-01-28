<?php  namespace Zbw\Bostonjohn\Datafeed;

use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Zbw\Core\Helpers;
use Curl\Curl;
use Zbw\Bostonjohn\Datafeed\Contracts\DatafeedParserInterface;
use Zbw\Users\Contracts\StaffingRepositoryInterface;
use Zbw\Users\StaffingFactory;
use Zbw\Users\StaffingRepository;
use Zbw\Users\UserRepository;

/**
 * @package Zbw\Bostonjohn\Datafeed
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class DatafeedParser implements DatafeedParserInterface
{
    /**
     * @var string
     */
    private $datafeed;

    /**
     * @var string
     */
    private $flightModel = \ZbwFlight::class;

    private $staffingRepo;

    /**
     * @var \Curl\Curl
     */
    private $curl;

    const CALLSIGN = 0;
    const CID = 1;
    const REALNAME = 2;
    const CLIENTTYPE = 3;
    const FREQUENCY = 4;
    const LATITUDE = 5;
    const LONGITUDE = 6;
    const ALTITUDE = 7;
    const GROUNDSPEED = 8;
    const AIRCRAFT = 9;
    const TASCRUISE = 10;
    const DEPAIRPORT = 11;
    const FP_ALTITUDE = 12;
    const DESTAIRPORT = 13;
    const SERVER = 14;
    const PROTREVISION = 15;
    const RATING = 16;
    const TRANSPONDER = 17;
    const FACILITYTYPE = 18;
    const VISUALRANGE = 19;
    const REVISION = 20;
    const FLIGHTTYPE = 21;
    const DEPTIME = 22;
    const ACTDEPTIME = 23;
    const HRSENROUTE = 24;
    const MINENROUTE = 25;
    const HRSFUEL = 26;
    const MINFUEL = 27;
    const ALTAIRPORT = 28;
    const REMARKS = 29;
    const ROUTE = 30;
    const DEPAIRPORT_LAT = 31;
    const DEPAIRPORT_LON = 32;
    const DESTAIRPORT_LAT = 33;
    const DESTAIRPORT_LON = 34;
    const ATIS_MESSAGE = 35;
    const TIME_LAST_ATIS_RECEIVED = 36;
    const TIME_LOGON = 37;
    const HEADING = 38;
    const QNH_IHG = 39;
    const QNH_MB = 40;


    public function __construct($curl = null, StaffingRepositoryInterface $staffingRepo = null)
    {
        $this->staffingRepo = is_null($staffingRepo) ? new StaffingRepository() : $staffingRepo;
        $this->curl = is_null($curl) ? new Curl() : $curl;
        $this->setDatafeed();
        $lines = strstr($this->datafeed, '!CLIENTS:');
        $lines = Helpers::makeLines($lines, false);
        $this->datafeed = $this->fetchLineParts($lines);
    }

    private function fetchLineParts($lines)
    {
        $newLines = [];
        foreach($lines as $line) {
            $newLines[] = $this->parseSingleLine($line);
        }

        return $newLines;
    }

    private function parseSingleLine($line)
    {
        $temp = explode(':', $line);
        if(count($temp) > 5) { //arbitrary, should be >>> 5
            return $temp;
        }
    }

    /**
     * @return void
     */
    private function setDatafeed()
    {
        $url = \Datafeed::where('key', 'data')->first();
        $this->curl->get($url->value);
        $this->datafeed = $this->curl->response;
    }

    /**
     * @return void
     */
    public function parseDatafeed()
    {
        foreach($this->datafeed as $line) {
            if(empty($line)) { continue; }
            $dfLine = new DatafeedLine($line);
            if($dfLine->isZbwAirport()) {
                $this->parseControllerLine($line);
            }
            else if($dfLine->isZbwFlight()) {
                $this->parsePilotLine($line);
            }
        }

        $this->closeStaffings();
    }

    /**
     * @param string $model
     * @throws ClassNotFoundException
     * @return void
     */
    public function setFlightModel($model)
    {
        if(! class_exists($model)) {
            throw new ClassNotFoundException("Class $model not found", new \ErrorException());
        }

        $this->flightModel = $model;
    }

    /**
     * parses a controller line from the datafeed. Creates
     *
     * @param $line
     * @return void
     */
    private function parseControllerLine($line)
    {
        if(is_array($line)) {
            $line = new DatafeedLine($line);
        }

        if(! $line instanceof DatafeedLine) {
            throw new \InvalidArgumentException("DatafeedLine expected, received" . gettype($line));
        }

        //parse the login time
        $start = $line->getStartTime();

        //is the controller already online?
        $online = \Staffing::where('start', $start)->where('cid', $line->cid())->get();
        if(! $line->isObserver()){
            if ($online->count() <= 0) {
                //create the new staffing
                $this->createStaffing($line, $start);
            } else {
                //update the existing one
                $online[0]->touch();
            }
        }
    }

    /**
     * @param $line
     * @return void
     */
    private function parsePilotLine($line)
    {
        $flight = new $this->flightModel();
        $flight->cid = is_int($line[$this::CID]) ? $line[$this::CID] : 0;
        $flight->callsign = $line[$this::CALLSIGN];
        $flight->departure = $line[$this::DEPAIRPORT];
        $flight->destination = $line[$this::DESTAIRPORT];
        $flight->is_arrival = in_array($line[$this::DESTAIRPORT], \Config::get('zbw.airports')) ? 1 : 0;
        $flight->route = $line[$this::ROUTE];
        $flight->name = $line[$this::REALNAME];
        $flight->aircraft = $line[$this::AIRCRAFT];
        $flight->altitude = $line[$this::FP_ALTITUDE];
        $flight->eta = $line[$this::HRSENROUTE];
        $flight->save();
    }

    /**
     * @return void
     */
    private function closeStaffings()
    {
        $staffings = $this->staffingRepo->getDaysOfStaffing(2);
        if($staffings->count() <= 0) {
            return;
        }

        foreach ($staffings as $entry) {
            $entry->checkExpiry();
            $this->staffingRepo->save($entry);
        }
    }

    /**
     * @param $line
     * @param $start
     * @return bool
     */
    private function createStaffing($line, $start)
    {
        $users = new UserRepository();
        if(! $users->exists($line->cid())) {
            return true;
        }

        $factory = new StaffingFactory();
        return $this->staffingRepo->save($factory->fromDatafeedLine($line->rawLine(), $start));
    }
}
