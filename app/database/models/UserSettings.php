<?php

/**
 * UserSettings
 *
 * @property integer $cid
 * @property boolean $n_private_message
 * @property boolean $n_exam_assigned
 * @property boolean $n_exam_comment
 * @property boolean $n_training_accepted
 * @property boolean $n_training_cancelled
 * @property boolean $n_events
 * @property boolean $n_news
 * @property boolean $n_exam_request
 * @property boolean $n_staff_exam_comment
 * @property boolean $n_training_request
 * @property boolean $n_staff_news
 * @property string $avatar
 * @property boolean $email_hidden
 * @property string $signature
 * @property string $ts_key
 * @property-read \User $user
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNPrivateMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNExamAssigned($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNExamComment($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNTrainingAccepted($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNTrainingCancelled($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNEvents($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNNews($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNExamRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNStaffExamComment($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNTrainingRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereNStaffNews($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereEmailHidden($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereSignature($value)
 * @method static \Illuminate\Database\Query\Builder|\UserSettings whereTsKey($value)
 */
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
