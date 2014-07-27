<?php

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
