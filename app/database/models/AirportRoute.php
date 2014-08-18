<?php

/**
 * AirportRoute
 *
 * @property integer $id
 * @property string $orig_icao
 * @property string $dest_icao
 * @property string $route
 * @property string $hours
 * @property string $type
 * @property string $area
 * @property string $altitude
 * @property string $aircraft
 * @property string $direction
 * @property integer $sequence
 * @property string $orig_artcc
 * @property string $dest_artcc
 * @property integer $stale
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereOrigIcao($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereDestIcao($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereRoute($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereHours($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereAltitude($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereAircraft($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereDirection($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereSequence($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereOrigArtcc($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereDestArtcc($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereStale($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\AirportRoute whereUpdatedAt($value)
 */
class AirportRoute extends BaseModel {
	protected $guarded = array();
	protected $table = 'airport_routes';
	public $rules = array();
}
