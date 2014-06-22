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

    public static function create($input)
    {
        $tr = new TrainingRequest();
        $tr->cid = $input['user'];
        $tr->start = $input['start'];
        $tr->end = $input['end'];
        $tr->cert = $input['cert'];
        return $tr->save();
    }
} 
