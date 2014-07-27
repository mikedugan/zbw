<?php

class Rating extends \Eloquent
{
    protected $guarded = [];
    protected $table = '_ratings';
    public $timestamps = false;
    static $rules = [
        'short' => 'max:3',
        'medium' => 'max:20',
        'long' => 'max:30',
        'grp' => 'max:30'
    ];
}
