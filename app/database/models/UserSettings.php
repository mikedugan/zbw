<?php

class UserSettings extends \Eloquent
{
    protected $table = 'user_settings';
    protected $guarded = ['cid'];
    public $timestamps = false;
    protected $primaryKey = 'cid';
    static $rules = [
        'cid' => 'integer',
        'email_hidden' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }
}
