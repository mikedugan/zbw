<?php 

class TrainingRequest extends Eloquent
{
    public $table = '_training_requests';

    public function certType()
    {
        return $this->hasOne('CertType', 'id', 'cert');
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
