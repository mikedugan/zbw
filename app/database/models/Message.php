<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Message extends BaseModel
{
    use SoftDeletingTrait;

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $guarded = [];
    protected $table = 'zbw_messages';
    static $rules = [
      'from'            => 'cid',
      'to'              => 'cid',
      'content'         => 'required',
      'has_attachments' => 'integer',
      'is_read'         => 'integer',
      'cid'             => 'cid'
    ];

    public function getDates()
    {
        return $this->dates;
    }

    //relations
    public function sender()
    {
        return $this->hasOne('User', 'cid', 'from');
    }

    public function recipient()
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
