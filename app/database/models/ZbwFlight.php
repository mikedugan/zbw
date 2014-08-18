<?php

/**
 * ZbwFlight
 *
 * @property integer $id
 * @property integer $cid
 * @property string $callsign
 * @property string $departure
 * @property string $destination
 * @property string $name
 * @property string $aircraft
 * @property string $altitude
 * @property string $eta
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $route
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereCallsign($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereDeparture($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereDestination($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereAircraft($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereAltitude($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereEta($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ZbwFlight whereRoute($value)
 */
class ZbwFlight extends BaseModel {
    protected $guarded = ['start', 'stop'];
    protected $table = '_flights';
    static $rules = [
        'cid' => 'cid|integer',
        'callsign' => '',
        'departure' => '',
        'destination' => '',
        'name' => '',
        'aircraft' => '',
        'altitude' => '',
        'eta' => '',
        'route' => ''
    ];

    public static function frontPage($lim)
    {
        return ZbwFlight::limit($lim)->get();
    }
}
