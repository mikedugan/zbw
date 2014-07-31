<?php

/**
 * AirportChart
 *
 * @property integer $id
 * @property string $icao
 * @property string $type
 * @property string $name
 * @property string $filename
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\AirportChart whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportChart whereIcao($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportChart whereType($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportChart whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportChart whereFilename($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportChart whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportChart whereUpdatedAt($value) 
 */
class AirportChart extends BaseModel {
	protected $guarded = array();
	protected $table = 'airport_charts';
	public $rules = array();
}
