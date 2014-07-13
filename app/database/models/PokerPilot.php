<?php

class PokerPilot extends Eloquent {
	protected $guarded = [];
	protected $table = 'zbw_pokerpilots';
	public $rules = [];

    public function cards()
    {
        return $this->hasMany('PokerCard', 'pid', 'pid');
    }
}
