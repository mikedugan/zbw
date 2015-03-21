<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $fillable = ['to', 'subject', 'content', 'from', 'cid'];
    protected $table = 'zbw_messages';
    static $rules = [
      'from'            => 'cid',
      'to'              => 'cid',
      'content'         => 'required|max:63000',
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

    public function markRead()
    {
        $this->is_read = 1;
        return $this->save();
    }

}
