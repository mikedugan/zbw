<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Message
 *
 * @property integer $id
 * @property integer $from
 * @property integer $to
 * @property string $subject
 * @property string $content
 * @property boolean $has_attachments
 * @property boolean $is_read
 * @property string $history
 * @property integer $cid
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \User $sender
 * @property-read \User $recipient
 * @method static \Illuminate\Database\Query\Builder|\Message whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereSubject($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereHasAttachments($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereIsRead($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Message whereUpdatedAt($value)
 */
class Message extends BaseModel
{
    use SoftDeletingTrait;

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
