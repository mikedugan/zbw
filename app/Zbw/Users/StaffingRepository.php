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

    public function getMostRecentAll()
    {
        $results = \DB::select("SELECT cid, MAX(start) as start from zbw_staffing GROUP BY cid");
        $ret = [];
        array_map(function($obj) use (&$ret) {
            $ret[$obj->cid] = \Carbon::createFromFormat('Y-m-d H:i:s', $obj->start);
        }, $results);
        return $ret;
    }
} 
