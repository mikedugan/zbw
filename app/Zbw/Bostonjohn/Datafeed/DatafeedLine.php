<?php namespace Zbw\Bostonjohn\Datafeed;

class DatafeedLine
{
    private $line;

    public function __construct(array $line)
    {
        if (empty($line)) {
            throw new \InvalidArgumentException("Line is empty");
        }
        $this->line = $line;
    }

    public function isZbwFlight()
    {
        //make sure the departure or desination airport is set
        if (array_key_exists(DatafeedParser::DEPAIRPORT, $this->line) &&
            array_key_exists(DatafeedParser::DESTAIRPORT, $this->line)
        ) {
            return in_array(substr($this->line[DatafeedParser::DEPAIRPORT], 0, 4), \Config::get('zbw.airports'))
            || in_array(substr($this->line[DatafeedParser::DESTAIRPORT], 0, 4), \Config::get('zbw.airports'));
        } else {
            return false;
        }
    }

    public function isZbwAirport()
    {
        //filter out observers and non-ZBW callsigns off the bat
        if ($this->hasInvalidPosition()) {
            return false;
        }
        //check that the position is in our list of IATA airports
        $itis = in_array(substr($this->line[0], 0, 3), \Config::get('zbw.iatas'));
        if ($itis) {
            //just to be sure there's no underscore funny business
            return $this->line[0][3] == '_' || $this->line[0][4] == '_';
        } else {
            return false;
        }
    }

    public function hasInvalidPosition()
    {
        return
        (isset($this->line[DatafeedParser::CALLSIGN][3]) && $this->line[DatafeedParser::CALLSIGN][3] !== '_')
        ||
        (isset($this->line[DatafeedParser::CALLSIGN][3]) && substr($this->line[DatafeedParser::FREQUENCY], 0, 3) == '199');
    }

    public function getStartTime()
    {
        return \Carbon::createFromFormat('YmdHis', $this->line[DatafeedParser::TIME_LOGON]);
    }

    public function isObserver()
    {
        return strpos($this->line[DatafeedParser::CALLSIGN], '_OBS') !== false;
    }

    public function cid()
    {
        return $this->line[DatafeedParser::CID];
    }

    public function rawLine()
    {
        return $this->line;
    }

}
