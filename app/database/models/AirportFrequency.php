<?php

/**
 * AirportFrequency
 *
 * @property integer $id
 * @property string $icao
 * @property string $name
 * @property string $freq1
 * @property string $freq2
 * @property string $freq3
 * @property string $freq4
 * @property string $freq5
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereIcao($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereFreq1($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereFreq2($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereFreq3($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereFreq4($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereFreq5($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportFrequency whereUpdatedAt($value) 
 */
class AirportFrequency extends BaseModel {
	protected $guarded = array();
	protected $table = 'airport_frequencies';
	public $rules = array();
}
