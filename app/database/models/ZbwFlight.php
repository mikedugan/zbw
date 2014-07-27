<?php

class ZbwFlight extends Eloquent {
    protected $guarded = ['start', 'stop'];
    protected $table = '_flights';
    static $rules = [
        'cid' => 'cid|integer',
        'callsign' => '',
        'departure' => '',
        'destination' => '',
        'name' => '',
        'aircraft' => '',
        'altitude' => '',
        'eta' => '',
        'route' => ''
    ];

    public static function frontPage($lim)
    {
        return ZbwFlight::limit($lim)->get();
    }
}
