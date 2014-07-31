<?php

/**
 * Staffing
 *
 * @property integer $id
 * @property integer $cid
 * @property string $position
 * @property \Carbon\Carbon $start
 * @property string $frequency
 * @property \Carbon\Carbon $stop
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \User $user
 * @method static \Illuminate\Database\Query\Builder|\Staffing whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Staffing whereCid($value) 
 * @method static \Illuminate\Database\Query\Builder|\Staffing wherePosition($value) 
 * @method static \Illuminate\Database\Query\Builder|\Staffing whereStart($value) 
 * @method static \Illuminate\Database\Query\Builder|\Staffing whereFrequency($value) 
 * @method static \Illuminate\Database\Query\Builder|\Staffing whereStop($value) 
 * @method static \Illuminate\Database\Query\Builder|\Staffing whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Staffing whereUpdatedAt($value) 
 */
class Staffing extends BaseModel {
    protected $guarded = ['start', 'stop'];
    protected $table = 'zbw_staffing';
    protected $dates = ['start', 'stop', 'created_at', 'updated_at'];
    static $rules = [
        'cid' => 'cid',
        'position' => '',
        'start' => 'date',
        'stop' => 'date',
        'frequency' => ''
    ];

    public function getDates()
    {
        return ['start', 'stop', 'created_at', 'updated_at'];
    }

    public function user()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public static function frontPage()
    {
        return Staffing::where('stop', null)->with(['user'])->get();
    }

    public static function getDaysOfStaffing($days = 3)
    {
        return \Staffing::where('updated_at', '>', Carbon::now()->subDays($days))->get();
    }
}
