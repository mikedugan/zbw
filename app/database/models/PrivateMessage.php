<?php

use Illuminate\Database\Eloquent\Builder;

class PrivateMessage extends Eloquent {
	protected $guarded = array();
	protected $table = 'zbw_messages';
	public $rules;

    //relations
    public function sender()
    {
        return $this->hasOne('User', 'cid', 'from');
    }

    public function recipients()
    {
        return $this->belongsTo('User', 'to', 'cid');
    }

    //scopes
    public function read($query)
    {
        return $query->where('is_read');
    }

    public function unread(\Illuminate\Database\Query\Builder $query)
    {
        return $query->where('is_read', 0);
    }

    public function userInbox($query, $id)
    {
        return $query->where('to', $id);
    }

    public function userOutbox($query, $id)
    {
        return $query->where('from', $id);
    }

}
