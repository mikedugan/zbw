<?php

class Schedule extends \Eloquent {
	protected $fillable = ['start','end','cid','position'];

    public function getDates()
    {
        return ['created_at','updated_at','start','end'];
    }

    public function controller()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public static function nextDay($n = 5)
    {
        return self::where('start', '<', \Carbon::tomorrow())->where('start','>',\Carbon::now())->with('controller')->orderBy('start', 'desc')->limit($n)->get();
    }
}
