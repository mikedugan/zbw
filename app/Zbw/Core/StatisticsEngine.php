<?php  namespace Zbw\Core; 

use Zbw\Users\Contracts\StaffingRepositoryInterface;

class StatisticsEngine
{
    private $staffings;

    public function __construct(StaffingRepositoryInterface $staffings)
    {
        $this->staffings = $staffings;
    }

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

    public function total($set)
    {
        $total = 0;
        foreach ($set as $obj) {
            $total += $obj->onlinetime;
        }

        return $this->timeDecimalToHi($total);
    }

    public function timeDecimalToHi($time)
    {
        $parts = explode('.', $time);
        $minutes = substr($parts[1], 0, 2) / 100;
        $minutes = str_pad(floor($minutes * 60), 2, '0', STR_PAD_LEFT);
        $time = $parts[0].':'.$minutes;
        return $time;
    }

    public function collectionDecimalToHi($set)
    {
        $ret = [];
        foreach($set as $obj) {
            $obj->onlinetime = $this->timeDecimalToHi($obj->onlinetime);
            array_push($ret, $obj);
        }

        return $ret;
    }
} 
