<?php

class PokerCard extends Eloquent {
	protected $guarded = [];
	protected $table = 'zbw_pokercards';
	public $rules = [];
    public $dates = ['discarded'];

    public function pilot()
    {
        return $this->belongsTo('PokerPilot', 'pid', 'pid');
    }

    public static function discard($id)
    {
        $card = \PokerCard::find($id);
        $card->discarded = \Carbon::now();
        return $card->save();
    }
}
