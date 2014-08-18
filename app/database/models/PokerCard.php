<?php

/**
 * PokerCard
 *
 * @property integer $id
 * @property integer $pid
 * @property string $created_at
 * @property string $updated_at
 * @property string $card
 * @property \Carbon\Carbon $discarded
 * @property-read \PokerPilot $pilot
 * @method static \Illuminate\Database\Query\Builder|\PokerCard whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerCard wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerCard whereCard($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerCard whereDiscarded($value)
 */
class PokerCard extends BaseModel
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
