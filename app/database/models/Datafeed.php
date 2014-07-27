<?php

class Datafeed extends BaseModel
{
    protected $guarded = [];
    protected $table = '_datafeeds';
    static $rules = [
        'key' => 'required',
        'value' => 'required',
        'expires' => 'date'
    ];
}
