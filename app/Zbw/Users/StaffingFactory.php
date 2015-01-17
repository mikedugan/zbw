<?php namespace Zbw\Users;

use Zbw\Bostonjohn\Datafeed\DatafeedParser;

class StaffingFactory
{
    public function fromDatafeedLine(array $line, $start)
    {
        $staffing = new \Staffing();
        $staffing->start = \Carbon::createFromFormat('m-d-Y h:i:s', $start);
        $staffing->cid = $line[DatafeedParser::CID];
        $staffing->position = $line[DatafeedParser::CALLSIGN];
        $staffing->frequency = $line[DatafeedParser::FREQUENCY];

        return $staffing;
    }
}
