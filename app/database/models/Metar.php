<?php

class Metar extends Eloquent {
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
