<?php

class UserSettings extends \Eloquent
{
    protected $table = 'user_settings';
    protected $guarded = ['cid'];
    public $timestamps = false;
    protected $primaryKey = 'cid';

    public function user()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }
}
