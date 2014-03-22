<?php  namespace Zbw\Repositories; 

class StaffingRepository
{
    protected $staffing;
    public function __construct($staffing = null)
    {
        $this->staffing = $staffing ? $staffing : null;
        $this->staffing->start = \Carbon::createFromDate($this->staffing->start);
        $this->staffing->stop = \Carbon::createFromDate($this->staffing->stop);
    }

    public function recent($n = 5)
    {
        return \ZbwStaffing::orderBy('stop')->take($n);
    }

    public function position($pos)
    {
        return \ZbwStaffing::where('position', '=', $pos);
    }

    public function getControllerStaffings($cid)
    {
        return \ZbwStaffing::where('cid', '=', $cid);
    }
} 
