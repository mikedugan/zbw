<?php

class StaffAvailability extends \Eloquent
{
    protected $table = 'staff_availability';

    protected $fillable = ['start', 'end', 'cid', 'comment','cert_id'];

    public function getDates()
    {
        return ['start', 'end', 'created_at', 'updated_at'];
    }

    public function controller()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public function level()
    {
        return $this->belongsTo('CertType', 'cert_id', 'id');
    }
}
