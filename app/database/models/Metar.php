<?php

/**
 * Metar
 *
 * @property integer $id
 * @property string $facility
 * @property string $raw
 * @property integer $time
 * @property integer $wind_direction
 * @property integer $wind_speed
 * @property integer $wind_gusts
 * @property boolean $visibility
 * @property string $sky
 * @property integer $temp
 * @property integer $dewpoint
 * @property string $altimeter
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Metar whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereFacility($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereRaw($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereTime($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereWindDirection($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereWindSpeed($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereWindGusts($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereVisibility($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereSky($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereTemp($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereDewpoint($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereAltimeter($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Metar whereUpdatedAt($value) 
 * @method static \Metar airport($icao) 
 */
class Metar extends BaseModel {
    protected $guarded = array();
    protected $table = 'metars';
    static $rules = [
        'facility' => '',
        'raw' => '',
        'time' => 'integer',
        'wind_direction' => 'integer',
        'wind_speed' => 'integer',
        'wind_gusts' => 'integer',
        'visbility' => 'integer',
        'sky' => '',
        'temp' => 'integer',
        'dewpoint' => 'integer',
        'altimeter' => ''
    ];

    public function scopeAirport($q, $icao)
    {
        return $q->where('facility', $icao);
    }

    public static function frontPage()
    {
        $ret = [];
        $airports = \Config::get('zbw.front_page_metars');
        foreach($airports as $airport) {
            $ret[] = \Metar::where('facility', $airport)->latest()->first();
        }

        return $ret;
    }

}
