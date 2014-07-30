<?php

/**
 * AirportRunway
 *
 * @property integer $id
 * @property string $icao
 * @property string $runway
 * @property integer $heading
 * @property integer $full_length
 * @property integer $width
 * @property integer $takeoff_dist
 * @property integer $landing_dist
 * @property string $ils_freq
 * @property string $ils_ident
 * @property string $ils_cat
 * @property integer $ils_course
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereIcao($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereRunway($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereHeading($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereFullLength($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereWidth($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereTakeoffDist($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereLandingDist($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereIlsFreq($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereIlsIdent($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereIlsCat($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereIlsCourse($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\AirportRunway whereUpdatedAt($value) 
 */
class AirportRunway extends BaseModel {
	protected $guarded = array();
	protected $table = 'airport_runways';
	public $rules = array();
}
