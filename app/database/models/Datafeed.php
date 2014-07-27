<?php

class Datafeed extends Eloquent
{
    protected $guarded = [];
    protected $table = '_datafeeds';
    static $rules = [
        'key' => 'required',
        'value' => 'required',
        'expires' => 'date'
    ];
}
