<?php

class PokerPilot extends Eloquent {
	protected $guarded = [];
	protected $table = 'zbw_pokerpilots';
	public $rules = [];

    public function cards()
    {
        return $this->hasMany('PokerCard', 'pid', 'pid');
    }

    public function hand($lim = 5)
    {
        return $this->cards()->where('discarded', null)->limit($lim)->get();
    }

    public static function getPilot($pid)
    {
        return \PokerPilot::where('pid', $pid)->get();
    }

    public static function exists($pid)
    {
        return \PokerPilot::where('pid', $pid)->count() > 0;
    }
}
