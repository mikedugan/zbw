<?php

class PokerCard extends Eloquent
{
    protected $guarded = [];
    protected $table = 'zbw_pokercards';
    public $dates = ['discarded'];
    static $rules = [
        'pid' => 'cid',
        'card' => '',
        'discarded' => 'date'
    ];

    public function getDates()
    {
        return ['discarded'];
    }

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
