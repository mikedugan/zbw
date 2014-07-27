<?php

class PendingExam extends BaseModel
{
    protected $fillable = ['cid', 'exam_id', 'cert_id'];
    protected $table = '_pending_exams';
    static $rules = [
        'exam_id' => 'integer',
        'cert_id' => 'integer',
    ];
}
