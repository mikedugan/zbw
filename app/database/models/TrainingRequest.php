<?php 

use Zbw\Base\Helpers;

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
class TrainingRequest extends BaseModel
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
        return ['start', 'end', 'completed_at'];
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

    public static function create(Array $input)
    {
        $tr = new TrainingRequest();
        $tr->cid = $input['user'];
        $tr->start = Helpers::convertToCarbon($input['start']);
        $tr->end = Helpers::convertToCarbon($input['end']);
        $tr->cert_id = $input['cert'];
        if($tr->save()) {
            \Queue::push('Zbw\Bostonjohn\QueueDispatcher@trainingNewRequest', $tr);
            return true;
        } else return false;
    }

    public static function accept($tsid, $cid)
    {
        $tr = TrainingRequest::find($tsid);
        if($tr->accepted_by) { return false;}
        $tr->sid = $cid;
        $tr->accepted_at = \Carbon::now();
        if($tr->save()) {
            \Queue::push('Zbw\Bostonjohn\QueueDispatcher@trainingAcceptRequest', $tr);
            return true;
        } else return false;
    }

    public static function drop($tsid, $cid)
    {
        $tr = TrainingRequest::find($tsid);
        if($tr->sid === $cid) {
            $tr->sid = null;
            $tr->accepted_at = null;
            if($tr->save()) {
                \Queue::push('Zbw\Bostonjohn\QueueDispatcher@trainingDropRequest', $tr);
                return true;
            } else return false;
        }
        else return false;

    }

    public static function complete($tsid, $report_id)
    {
        $tr = TrainingRequest::find($tsid);
        if($tr->is_completed) { return false; }
        $tr->is_completed = true;
        $tr->training_session_id= $report_id;
        $tr->completed_at = \Carbon::now();
        return $tr->save();
    }
} 
