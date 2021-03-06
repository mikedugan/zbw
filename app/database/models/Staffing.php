<?php
use Robbo\Presenter\PresentableInterface;
use Zbw\Users\Presenters\StaffingPresenter;

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
class Staffing extends BaseModel implements PresentableInterface
{
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

    public function getPresenter()
    {
        return new StaffingPresenter($this);
    }

    public function user()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public function expired()
    {
        return $this->updated_at < \Carbon::now()->subMinutes(4) && ! $this->stop;
    }

    public function checkExpiry()
    {
        if($this->expired()) {
            $this->stop = \Carbon::now();
            return true;
        }

        return false;
    }

    public static function frontPage()
    {
        return Staffing::where('stop', '0000-00-00 00:00:00')->orWhere('stop', null)->with(['user'])->get();
    }

    public static function getDaysOfStaffing($days = 3)
    {
        return \Staffing::where('updated_at', '>', Carbon::now()->subDays($days))->get();
    }

    public static function positionsOnline()
    {
        return \Staffing::where('stop', '0000-00-00 00:00:00')->orWhere('stop', null)->lists('position');
    }

    public static function recentStaffings($n = 5)
    {
        return self::limit($n)->with(['user'])->orderBy('created_at', 'DESC')->get();
    }
}
