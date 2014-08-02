<?php

/**
 * PendingExam
 *
 * @property integer $id
 * @property boolean $exam_id
 * @property boolean $cert_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\PendingExam whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\PendingExam whereExamId($value) 
 * @method static \Illuminate\Database\Query\Builder|\PendingExam whereCertId($value) 
 * @method static \Illuminate\Database\Query\Builder|\PendingExam whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\PendingExam whereUpdatedAt($value) 
 */
class PendingExam extends BaseModel
{
    protected $fillable = ['cid', 'exam_id', 'cert_id'];
    protected $table = '_pending_exams';
    static $rules = [
        'exam_id' => 'integer',
        'cert_id' => 'integer',
    ];
}
