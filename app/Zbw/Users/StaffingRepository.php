<?php  namespace Zbw\Users;

use Zbw\Users\Contracts\StaffingRepositoryInterface;

class StaffingRepository implements StaffingRepositoryInterface
{
    protected $staffing;

    public function recent($n = 5)
    {
        return \Staffing::orderBy('stop')->take($n);
    }

    public function position($pos)
    {
        return \Staffing::where('position', '=', $pos);
    }

    public function getControllerStaffings($cid)
    {
        return \Staffing::where('cid', '=', $cid);
    }
} 
