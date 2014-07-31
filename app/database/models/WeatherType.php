<?php

/**
 * WeatherType
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\WeatherType whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\WeatherType whereValue($value) 
 */
class WeatherType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_weather_types';
    public $timestamps = false;
    static $rules = [
      'value' => 'required'
    ];
}
