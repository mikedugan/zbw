<?php
use Robbo\Presenter\PresentableInterface;
use Zbw\Training\Presenters\TrainingSessionPresenter;

/**
 * TrainingSession
 * @property integer                $id
 * @property integer                $cid
 * @property integer                $sid
 * @property string                 $session_date
 * @property boolean                $weather_id
 * @property boolean                $complexity_id
 * @property boolean                $workload_id
 * @property string                 $staff_comment
 * @property string                 $student_comment
 * @property boolean                $is_ots
 * @property boolean                $facility_id
 * @property boolean                $brief_time
 * @property boolean                $position_time
 * @property boolean                $is_live
 * @property boolean                $training_type_id
 * @property \Carbon\Carbon         $created_at
 * @property \Carbon\Carbon         $updated_at
 * @property-read \User             $student
 * @property-read \User             $staff
 * @property-read \TrainingReport   $trainingReport
 * @property-read \TrainingFacility $facility
 * @property-read \TrainingType     $trainingType
 * @property-read \WeatherType      $weatherType
 * @property-read \ComplexityType   $complexityType
 * @property-read \WorkloadType     $workloadType
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereSid($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereSessionDate($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereWeatherId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereComplexityId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereWorkloadId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereStaffComment($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereStudentComment($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereIsOts($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereFacilityId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereBriefTime($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession wherePositionTime($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereIsLive($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereTrainingTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingSession whereUpdatedAt($value)
 * @method static \TrainingSession older($date)
 * @method static \TrainingSession newer($date)
 */
class TrainingSession extends BaseModel implements PresentableInterface
{
    protected $guarded = ['cid', 'sid'];
    protected $table = 'controller_training_sessions';
    protected $dates = ['created_at', 'updated_at', 'session_date'];
    static $rules = [
      'cid'              => 'cid|integer',
      'sid'              => 'cid|integer',
      'session_date'     => 'date',
      'weather_id'       => 'integer',
      'complexity_id'    => 'integer',
      'workload_id'      => 'integer',
      'staff_comment'    => '',
      'student_comment'  => '',
      'is_ots'           => 'integer',
      'facility_id'      => 'integer',
      'brief_time'       => 'integer',
      'position_time'    => 'integer',
      'is_live'          => 'integer',
      'training_type_id' => 'integer'
    ];

    public function getDates()
    {
        return $this->dates;
    }

    public function getPresenter()
    {
        return new TrainingSessionPresenter($this);
    }

    //scopes
    /**
     * @param $query eloquent query
     * @param $date  \Carbon object
     * @return Eloquent query
     */
    public function scopeOlder($query, $date)
    {
        return $query->where('session_date', '<', $date);
    }

    /**
     * @param $query eloquent query
     * @param $date  \Carbon object
     * @return Eloquent query
     */
    public function scopeNewer($query, $date)
    {
        return $query->where('session_date', '>', $date);
    }

    //relations
    /**
     * @return User
     */
    public function student()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    /**
     * @return User
     */
    public function staff()
    {
        return $this->belongsTo('User', 'sid', 'cid');
    }

    public function trainingReport()
    {
        return $this->hasOne('TrainingReport', 'training_session_id', 'id');
    }

    /**
     * @return TrainingFacility
     */
    public function facility()
    {
        return $this->hasOne('TrainingFacility', 'id', 'facility_id');
    }

    public function trainingType()
    {
        return $this->hasOne('TrainingType', 'id', 'training_type_id');
    }

    /**
     * @return WeatherType
     */
    public function weatherType()
    {
        return $this->hasOne('WeatherType', 'id', 'weather_id');
    }

    /**
     * @return ComplexityType
     */
    public function complexityType()
    {
        return $this->hasOne('ComplexityType', 'id', 'complexity_id');
    }

    /**
     * @return WorkloadType
     */
    public function workloadType()
    {
        return $this->hasOne('WorkloadType', 'id', 'workload_id');
    }
}
