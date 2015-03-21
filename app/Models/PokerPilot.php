<?php

/**
 * PokerPilot
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $country
 * @property integer $pid
 * @property-read \Illuminate\Database\Eloquent\Collection|\PokerCard[] $cards
 * @method static \Illuminate\Database\Query\Builder|\PokerPilot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerPilot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerPilot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerPilot whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerPilot whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerPilot whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\PokerPilot wherePid($value)
 */
class PokerPilot extends BaseModel
{
    protected $guarded = [];
    protected $table = 'zbw_pokerpilots';
    static $rules = [
      'first_name' => '',
      'last_name'  => '',
      'country'    => '',
      'pid'        => 'cid'
    ];

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
