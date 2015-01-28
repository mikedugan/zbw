<?php namespace Zbw\Users;

use Zbw\Bostonjohn\Datafeed\DatafeedParser;

class StaffingFactory
{
    public function fromDatafeedLine(array $line, $start)
    {
        $staffing = new \Staffing();
        try {
            $staffing->start = \Carbon::createFromFormat('m-d-Y h:i:s', $start);
        } catch (\InvalidArgumentException $e) {
            $staffing->start = \Carbon::now();
            \Bugsnag::notifyException($e, null, 'warning');
        }
        $staffing->cid = $line[DatafeedParser::CID];
        $staffing->position = $line[DatafeedParser::CALLSIGN];
        $staffing->frequency = $line[DatafeedParser::FREQUENCY];

        return $staffing;
    }
}
