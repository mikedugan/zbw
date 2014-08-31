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
        foreach ($set as $obj) {
            $total += $obj->onlinetime;
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
        $ret = [];
        foreach($set as $obj) {
            $parts = explode('_', $obj->position);
            $facility = $parts[0];
            $position = array_pop($parts);
            $new_facility = $facility.'_'.$position;
            if(array_key_exists($parts[0], $ret) && array_key_exists(array_pop($parts), $ret)) {
                $ret[$new_facility]['time'] += $obj->onlinetime;
                $ret[$new_facility]['position'] = $new_facility;
            } else {
                $ret[$new_facility]['time'] = $obj->onlinetime;
                $ret[$new_facility]['position'] = $new_facility;
            }
        }
        rsort($ret);
        return $ret;
    }
} 
