<?php

/**
 * PilotFeedback
 *
 * @property integer $id
 * @property string $controller
 * @property boolean $rating
 * @property string $name
 * @property string $email
 * @property string $ip
 * @property string $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereController($value)
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PilotFeedback whereUpdatedAt($value)
 */
class PilotFeedback extends BaseModel
{
    protected $guarded = ['email'];
    protected $table = 'pilot_feedback';
    static $rules = [
        'controller' => 'integer',
        'rating' => 'integer',
        'name' => '',
        'email' => 'email',
        'ip' => 'ip',
        'comments' => ''
    ];
}
