<?php 

class TrainingRequest extends Eloquent
{
    public $table = '_training_requests';
    public function getDates()
    {
        return ['start', 'end'];
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
        $tr->start = str_replace('/', '-', $input['start']).':00';
        $tr->end = str_replace('/', '-', $input['end']).':00';
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
        return $tr->save();
    }

    public static function drop($tsid, $cid)
    {
        $tr = TrainingRequest::find($tsid);
        if($tr->sid === $cid) {
            $tr->sid = null;
            $tr->accepted_at = null;
            return $tr->save();
        }
        else return false;

    }

    public static function complete($tsid)
    {
        $tr = TrainingRequest::find($tsid);
        if($tr->is_completed) { return false; }
        $tr->is_completed = true;
        $tr->completed_at = \Carbon::now();
        return $tr->save();
    }
} 
