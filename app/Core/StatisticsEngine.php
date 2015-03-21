<?php  namespace Zbw\Core; 

use Zbw\Users\Contracts\StaffingRepositoryInterface;

class StatisticsEngine
{
    private $staffings;

    /**
     * @param StaffingRepositoryInterface $staffings
     */
    public function __construct(StaffingRepositoryInterface $staffings)
    {
        $this->staffings = $staffings;
    }

    /**
     * @param $name
     * @param $args
     * @return array
     */
    public function __call($name, $args)
    {
        if(empty($args)) { $args[0] = 10; }
        $func = 'getTop'.ucfirst($name);
        $set = $this->staffings->{$func}($args[0]);
        $data = [
            'total' => $this->total($set),
            'set' => $this->collectionDecimalToHi($set)
        ];
        return $data;
    }

    /**
     * @param array $set
     * @return string
     */
    public function total($set)
    {
        $total = 0;
        if(is_array($set[0])) {
            foreach ($set as $obj) {
                $total += $obj['time'];
            }
        } else {
            foreach ($set as $obj) {
                $total += $obj->onlinetime;
            }
        }

        return $this->timeDecimalToHi($total);
    }

    /**
     * @param int $lim
     * @return array
     */
    public function positions($lim = 10)
    {
        $positions = $this->staffings->getAllPositions($lim);
        return $this->reducePositions($positions);
    }

    /**
     * @param array $time
     * @return string
     */
    public function timeDecimalToHi($time)
    {
        if(!strpos('.', $time)) {$time .= '.0'; }
        $parts = explode('.', $time);
        $minutes = substr($parts[1], 0, 2) / 100;
        $minutes = str_pad(floor($minutes * 60), 2, '0', STR_PAD_LEFT);
        $time = $parts[0].':'.$minutes;
        return $time;
    }

    /**
     * @param array $set
     * @return array
     */
    public function collectionDecimalToHi($set)
    {
        $ret = [];
        foreach($set as $obj) {
            $obj->onlinetime = $this->timeDecimalToHi($obj->onlinetime);
            array_push($ret, $obj);
        }

        return $ret;
    }

    /**
     * @param array $set
     * @return array
     */
    private function reducePositions($set)
    {
        $raw_ret = [];
        foreach($set as $obj) {
            $parts = explode('_', $obj->position);
            $facility = $parts[0];
            $position = array_pop($parts);
            $new_facility = $facility.'_'.$position;
            if(array_key_exists($parts[0], $raw_ret) && array_key_exists(array_pop($parts), $raw_ret)) {
                $raw_ret[$new_facility]['time'] += $obj->onlinetime;
                $raw_ret[$new_facility]['position'] = $new_facility;
            } else {
                $raw_ret[$new_facility]['time'] = $obj->onlinetime;
                $raw_ret[$new_facility]['position'] = $new_facility;
            }
        }

        rsort($raw_ret);

        $ret = [];
        foreach($raw_ret as $facility => $arr) {
            $arr['time'] = $this->timeDecimalToHi($arr['time']);
            $ret[$facility] = $arr;
        }

        return $ret;
    }
} 
