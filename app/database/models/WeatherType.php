<?php

class WeatherType extends Eloquent
{
    protected $fillable = ['type'];
    protected $table = '_weather_types';
    public $timestamps = false;
    static $rules = [
      'value' => 'required'
    ];
}
