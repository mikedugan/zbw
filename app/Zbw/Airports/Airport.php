<?php namespace Zbw\Airports;

use Illuminate\Database\Eloquent\Model;

/**
 * Zbw\Airports\Airport
 *
 * @property integer        $id
 * @property string         $icao
 * @property string         $airspace
 * @property string         $iata
 * @property string         $name
 * @property string         $lat
 * @property string         $lon
 * @property integer        $elevation
 * @property string         $tracon
 * @property string         $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Airport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereIcao($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereAirspace($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereIata($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereLon($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereElevation($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereTracon($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Airport whereUpdatedAt($value)
 */
class Airport extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
}
