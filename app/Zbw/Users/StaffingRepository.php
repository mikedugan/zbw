<?php  namespace Zbw\Users;

use Zbw\Core\EloquentRepository;
use Zbw\Users\Contracts\StaffingRepositoryInterface;

class StaffingRepository extends EloquentRepository implements StaffingRepositoryInterface
{
    protected $staffing;

    public $model = '\Staffing';

    /**
     * @param int $n
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function recent($n = 5)
    {
        return \Staffing::orderBy('stop')->take($n);
    }

    public function paginateAll($n = 20)
    {
        return $this->make()->with(['user'])->orderBy('created_at', 'DESC')->paginate($n);
    }

    /**
     * @param $pos
     * @return \Illuminate\Database\Query\Builder
     */
    public function position($pos)
    {
        return \Staffing::where('position', '=', $pos);
    }

    /**
     * @param $cid
     * @return \Illuminate\Database\Query\Builder
     */
    public function getControllerStaffings($cid)
    {
        return \Staffing::where('cid', '=', $cid);
    }

    /**
     * @return array
     */
    public function getMostRecentAll()
    {
        $results = \DB::select("SELECT cid, MAX(created_at) as start from zbw_staffing GROUP BY cid");
        $ret = [];
        array_map(function($obj) use (&$ret) {
            $ret[$obj->cid] = \Carbon::createFromFormat('Y-m-d H:i:s', $obj->start);
        }, $results);
        return $ret;
    }

    /**
     * @param int $lim
     * @return array
     */
    public function getTopPositions($lim = 10)
    {
        $results = \DB::select(
          "SELECT cid, position, (SUM(UNIX_TIMESTAMP(s.stop) - UNIX_TIMESTAMP(s.created_at))/3600) AS onlinetime
            FROM zbw_staffing GROUP BY position ORDER BY onlinetime DESC LIMIT ?", [$lim]);
        return $results;
    }

    /**
     * @param int $lim
     * @return array
     */
    public function getAllPositions($lim = 10)
    {
        $results = \DB::select(
          "SELECT cid, position, (SUM(UNIX_TIMESTAMP(stop) - UNIX_TIMESTAMP(created_at))/3600) AS onlinetime
            FROM zbw_staffing GROUP BY position ORDER BY onlinetime DESC LIMIT ?", [$lim]);
        return $results;
    }


    /**
     * @param int $lim
     * @return array
     */
    public function getTopOverall($lim = 10)
    {
        $results = \DB::select(
            "SELECT u.username, u.initials, s.cid, s.position, (SUM(UNIX_TIMESTAMP(s.stop) - UNIX_TIMESTAMP(s.created_at))/3600) AS onlinetime
            FROM zbw_staffing AS s LEFT JOIN users AS u ON u.cid=s.cid GROUP BY s.cid ORDER BY onlinetime DESC LIMIT ?", [$lim]);
        return $results;
    }

    /**
     * @param int $lim
     * @return array
     */
    public function getTopCenter($lim = 10)
    {
        $results = \DB::select(
          "SELECT u.username, u.initials, s.cid, s.position, (SUM(UNIX_TIMESTAMP(s.stop) - UNIX_TIMESTAMP(s.created_at))/3600) AS onlinetime
            FROM zbw_staffing AS s LEFT JOIN users AS u ON u.cid=s.cid WHERE position LIKE '%_CTR' GROUP BY s.cid ORDER BY onlinetime DESC LIMIT ?", [$lim]);
        return $results;
    }

    /**
     * @param int $lim
     * @return array
     */
    public function getTopMonth($lim = 10)
    {
        $start = \Carbon::now()->subMonth();
        $results = \DB::select(
          "SELECT u.username, u.initials, s.cid, s.position, (SUM(UNIX_TIMESTAMP(s.stop) - UNIX_TIMESTAMP(s.created_at))/3600) AS onlinetime
            FROM zbw_staffing AS s LEFT JOIN users AS u ON u.cid=s.cid WHERE s.created_at > ? GROUP BY s.cid ORDER BY onlinetime DESC LIMIT ?", [$start, $lim]);
        return $results;
    }

    /**
     * @param int $lim
     * @return array
     */
    public function getTopLastMonth($lim = 10)
    {
        $start = \Carbon::now()->subMonths(2);
        $end = \Carbon::now()->subMonth();
        $results = \DB::select(
          "SELECT u.username, u.initials, s.cid, s.position, (SUM(UNIX_TIMESTAMP(s.stop) - UNIX_TIMESTAMP(s.created_at))/3600) AS onlinetime
            FROM zbw_staffing AS s LEFT JOIN users AS u ON u.cid=s.cid WHERE s.created_at BETWEEN ? AND ? GROUP BY s.cid ORDER BY onlinetime DESC LIMIT ?", [$start, $end, $lim]);
        return $results;
    }

    /**
     * @param int $lim
     * @return array
     */
    public function getTopTracon($lim = 10)
    {
        $results = \DB::select(
            "SELECT u.username, u.initials, s.cid, s.position, (SUM(UNIX_TIMESTAMP(s.stop) - UNIX_TIMESTAMP(s.created_at))/3600) AS onlinetime
            FROM zbw_staffing AS s LEFT JOIN users AS u ON u.cid=s.cid WHERE position LIKE '%_APP' OR position LIKE '%_DEP' GROUP BY s.cid ORDER BY onlinetime DESC LIMIT ?", [$lim]);
        return $results;
    }

    /**
     * @param int $lim
     * @return array
     */
    public function getTopGround($lim = 10)
    {
        $results = \DB::select("
            SELECT u.username, u.initials, s.cid, s.position, (SUM(UNIX_TIMESTAMP(s.stop) - UNIX_TIMESTAMP(s.created_at))/3600) AS onlinetime
            FROM zbw_staffing AS s LEFT JOIN users AS u ON u.cid=s.cid WHERE position LIKE '%_GND' OR position LIKE '%_DEL' GROUP BY s.cid ORDER BY onlinetime DESC LIMIT ?", [$lim]);
        return $results;
    }

    /**
     * @param int $lim
     * @return array
     */
    public function getTopTower($lim = 10)
    {
        $results = \DB::select("
            SELECT u.username, u.initials, s.cid, s.position, (SUM(UNIX_TIMESTAMP(s.stop) - UNIX_TIMESTAMP(s.created_at))/3600) AS onlinetime
            FROM zbw_staffing AS s LEFT JOIN users AS u ON u.cid=s.cid WHERE position LIKE '%_TWR' GROUP BY s.cid ORDER BY onlinetime DESC LIMIT ?", [$lim]);
        return $results;
    }

    public function getDaysOfStaffing($days = 2)
    {
        return $this->make()->where('updated_at', '>', \Carbon::now()->subDays($days))->get();
    }

    /**
     * @param $input
     * @return mixed
     */
    public function update($input)
    {
        return true;
    }
}
