<?php

class Metar extends Eloquent {
    protected $guarded = array();
    protected $table = 'metars';
    public $rules = array();

    public function scopeAirport($q, $icao)
    {
        return $q->where('facility', $icao);
    }

    public static function frontPage()
    {
        $ret = [];
        $airports = \Config::get('zbw.front_page_metars');
        foreach($airports as $airport) {
            $ret[] = \Metar::where('facility', $airport)->latest()->get()[0];
        }

        return $ret;
    }

}
