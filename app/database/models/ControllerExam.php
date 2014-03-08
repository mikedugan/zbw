<?php

class ControllerExam extends Eloquent {
    protected $guarded = ['exam_id', 'reviewed'];
    protected $table = 'controller_exams';
    public static $rules = array();
}
