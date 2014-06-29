<?php 

class TrainingRequest extends Eloquent
{
    public $table = '_training_requests';

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
        $tr->start = $input['start'];
        $tr->end = $input['end'];
        $tr->cert = $input['cert'];
        return $tr->save();
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

    public static function complete($tsid, $cid)
    {
        $tr = TrainingRequest::find($tsid);
        if($tr->is_completed) { return false; }
        $tr->is_completed = true;
        $tr->completed_at = \Carbon::now();
        return $tr->save();
    }
} 
