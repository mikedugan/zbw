<?php

class ControllerSetting extends Eloquent
{
    protected $guarded = ['cid'];
    protected $table = 'zbw_controller_settings';
    public $timestamps = false;
    static $rules = [
        'cid' => 'cid|integer',
        'n_private_message' => 'integer',
        'n_exam_assigned' => 'integer',
        'n_exam_comment' => 'integer',
        'n_training_accepted' => 'integer',
        'n_training_cancelled' => 'integer',
        'n_events' => 'integer',
        'n_news' => 'integer',
        'n_exam_request' => 'integer',
        'n_staff_exam_comment' => 'integer',
        'n_training_request' => 'integer',
        'n_staff_news' => 'integer',
        'email_hidden' => 'integer',
        //'signature' => '',
        //'avatar' => '',
        //'ts_key' => '',
    ];
}
