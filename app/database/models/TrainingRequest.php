<?php

use Robbo\Presenter\PresentableInterface;
use Zbw\Core\Helpers;
use Zbw\Training\Presenters\TrainingRequestPresenter;

/**
 * TrainingRequest
 *
 * @property integer $id
 * @property integer $cid
 * @property integer $sid
 * @property \Carbon\Carbon $start
 * @property \Carbon\Carbon $end
 * @property boolean $cert_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $accepted_by
 * @property string $accepted_at
 * @property boolean $is_completed
 * @property \Carbon\Carbon $completed_at
 * @property integer $training_session_id
 * @property-read \CertType $certType
 * @property-read \User $student
 * @property-read \User $staff
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereSid($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereCertId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereAcceptedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereAcceptedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereIsCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereCompletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingRequest whereTrainingSessionId($value)
 */
class TrainingRequest extends BaseModel implements PresentableInterface
{
    public $table = '_training_requests';
    static $rules = [
        'cid' => 'cid|integer',
        'sid' => 'cid|integer',
        'start' => 'date',
        'end' => 'date',
        'cert_id' => 'integer',
        'accepted_by' => 'cid|integer',
        'accepted_at' => 'date',
        'is_completed' => 'integer',
        'completed_at' => 'date'
    ];

    public function getDates()
    {
        return ['start', 'end', 'completed_at','created_at','updated_at','completed_at'];
    }

    public function getPresenter()
    {
        return new TrainingRequestPresenter($this);
    }

    public function certType()
    {
        return $this->hasOne('CertType', 'id', 'cert_id');
    }

    public function student()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public function staff()
    {
        return $this->belongsTo('User', 'sid', 'cid');
    }
} 
