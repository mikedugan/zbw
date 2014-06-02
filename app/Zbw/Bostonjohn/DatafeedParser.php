<?php  namespace Zbw\Bostonjohn;

use Zbw\Helpers;

class DatafeedParser {
    public $datafeed;
    private $controllers;
    private $pilots;

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


    public function __construct($datafeed)
    {
        $modlines = [];
        $lines = strstr($datafeed, '!CLIENTS:');
        $lines = Helpers::makeLines($lines, false);
        foreach($lines as $line) {
            $templine = explode(':', $line);
            if(count($templine) > 5)
                $modlines[] = $templine;
        }
        $this->datafeed = $modlines;
    }

    public function parseDatafeed()
    {
        $controllers = [];
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

    public function parseControllerLine($line)
    {
        if(empty($line[$this::TIME_LOGON])) dd($line);
        $start = \Carbon::createFromFormat('YmdHis', $line[$this::TIME_LOGON]);
        $online = \ZbwStaffing::where('start', $start)->where('cid', $line[$this::CID])->get();
        if(! count($online) > 0) {
            $staffing = new \ZbwStaffing();
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

    public function parsePilotLine($line)
    {
        return true;
    }

    private function closeStaffings()
    {
        $lastUpdate = \ZbwStaffing::latest()->first()->updated_at;
        foreach(\ZbwStaffing::all() as $row) {
            if($row->updated_at->lt($lastUpdate->subMinutes(3)) && (! $row->stop)) {
                $row->stop = \Carbon::now();
                $row->save();
            }
        }
    }

    private function isZbwFlight($line)
    {
        return in_array(substr($line[11], 0, 4), \Config::get('zbw.airports'));
    }

    /**
     * @name  isZbwAirport
     * @description
     * @param $line
     * @return bool
     */
    private function isZbwAirport($line)
    {
        $itis = in_array(substr($line[0], 0, 3), \Config::get('zbw.iatas'));
        if($itis)
        {
            return $line[0][3] == '_' || $line[0][4] == '_';
        }
        else return false;
    }
} 