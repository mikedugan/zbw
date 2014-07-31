<?php

/**
 * AirportGeo
 *
 * @property integer $id
 * @property string $icao
 * @property string $airspace
 * @property string $faa_id
 * @property string $name
 * @property string $lat
 * @property string $lon
 * @property integer $elevation
 * @property string $tracon
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereIcao($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereAirspace($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereFaaId($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereLat($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereLon($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereElevation($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereTracon($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereLocation($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportGeo whereUpdatedAt($value) 
 */
class AirportGeo extends BaseModel {
	protected $guarded = array();
	protected $table = 'airport_geo';
	public $rules = array();
}
