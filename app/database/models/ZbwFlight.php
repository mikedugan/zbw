<?php

class ZbwFlight extends Eloquent {
    protected $guarded = ['start', 'stop'];
    protected $table = '_flights';
    public $rules = [
        'cid' => 'integer',
    ];

    public static function frontPage()
    {
        return ZbwFlight::all();
    }
}
