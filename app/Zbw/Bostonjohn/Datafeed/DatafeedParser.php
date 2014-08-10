<?php  namespace Zbw\Bostonjohn\Datafeed;

use Carbon\Carbon;
use Zbw\Base\Helpers;
use Curl\Curl;
use Zbw\Bostonjohn\Datafeed\Contracts\DatafeedParserInterface;

class DatafeedParser implements DatafeedParserInterface
{
    private $datafeed;
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


    public function __construct()
    {
        $this->curl = new Curl();
        $this->setDatafeed();
        $modlines = [];
        $lines = strstr($this->datafeed, '!CLIENTS:');
        $lines = Helpers::makeLines($lines, false);
        foreach($lines as $line) {
            $templine = explode(':', $line);
            if(count($templine) > 5)
                $modlines[] = $templine;
        }
        $this->datafeed = $modlines;
    }

    private function setDatafeed()
    {
        $url = \Datafeed::where('key', 'data')->first();
        $this->curl->get($url->value);
        $this->datafeed = $this->curl->response;
    }

    /**
     * @name parseDatafeed
     * @description
     * @return void
     */
    public function parseDatafeed()
    {
        foreach($this->datafeed as $line) {
            if($this->isZbwAirport($line)) {
                $this->parseControllerLine($line);
            }

            else if($this->isZbwFlight($line)) {
                $this->parsePilotLine($line);
            }
        }

        $this->closeStaffings();
    }

    /**
     * @name  parseControllerLine
     * @description
     * @param $line
     * @return void
     */
    private function parseControllerLine($line)
    {
        if(empty($line[$this::TIME_LOGON])) dd($line);
        $start = \Carbon::createFromFormat('YmdHis', $line[$this::TIME_LOGON]);
        $online = \Staffing::where('start', $start)->where('cid', $line[$this::CID])->get();
        if(! count($online) > 0) {
            $staffing = new \Staffing();
            $staffing->cid = $line[$this::CID];
            $staffing->start = $start;
            $staffing->position = $line[$this::CALLSIGN];
            $staffing->frequency = $line[$this::FREQUENCY];
            $staffing->save();
        }
        else {
            $online[0]->touch();
        }
    }

    /**
     * @name  parsePilotLine
     * @description
     * @param $line
     * @return void
     */
    private function parsePilotLine($line)
    {
        $flight = new \ZbwFlight();
        $flight->cid = $line[$this::CID];
        $flight->callsign = $line[$this::CALLSIGN];
        $flight->departure = $line[$this::DEPAIRPORT];
        $flight->destination = $line[$this::DESTAIRPORT];
        $flight->route = $line[$this::ROUTE];
        $flight->name = $line[$this::REALNAME];
        $flight->aircraft = $line[$this::AIRCRAFT];
        $flight->altitude = $line[$this::FP_ALTITUDE];
        $flight->eta = $line[$this::HRSENROUTE];

        $flight->save();
    }

    /**
     * @name closeStaffings
     * @description
     * @return void
     */
    private function closeStaffings()
    {
        $staffings = \Staffing::getDaysOfStaffing(2);
        if(count($staffings) > 0) {
            foreach ($staffings as $row) {
                if(($row->updated_at < \Carbon::now()->subMinutes(3)) && ( ! $row->stop)) {
                    $row->stop = \Carbon::now();
                    $row->save();
                }
            }
        }
    }

    /**
     * @name  isZbwFlight
     * @description checks a pilot line from the datafeed to determine if it is a ZBW flight
     * @param $line
     * @return bool
     */
    private function isZbwFlight($line)
    {
        if(array_key_exists($this::DEPAIRPORT, $line) && array_key_exists($this::DESTAIRPORT, $line))
            return in_array(substr($line[$this::DEPAIRPORT], 0, 4), \Config::get('zbw.airports'))
                    || in_array(substr($line[$this::DESTAIRPORT], 0, 4), \Config::get('zbw.airports'));
        else return false;
    }

    /**
     * @name  isZbwAirport
     * @description determines if a given airport is in ZBW airspace
     * @param $line
     * @return bool
     */
    private function isZbwAirport($line)
    {
        //filter out observers and non-ZBW callsigns off the bat
        if($this->positionInvalid($line)) return false;
        $itis = in_array(substr($line[0], 0, 3), \Config::get('zbw.iatas'));
        if($itis)
        {
            return $line[0][3] == '_' || $line[0][4] == '_';
        }
        else return false;
    }

    /**
     * @name  positionIsValid
     * @param $line
     * @return bool
     */
    private function positionInvalid($line)
    {
        return (isset($line[$this::CALLSIGN][3]) && $line[$this::CALLSIGN][3] !== '_') || (isset($line[$this::CALLSIGN][3]) && substr($line[$this::FREQUENCY], 0, 3) == '199');
    }
} 
