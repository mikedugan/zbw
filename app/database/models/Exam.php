<?php

/**
 * Exam
 *
 * @property integer $id
 * @property integer $exam_id
 * @property integer $cid
 * @property integer $reviewed_by
 * @property \Carbon\Carbon $assigned_on
 * @property boolean $cert_id
 * @property boolean $reviewed
 * @property string $wrong_questions
 * @property string $wrong_answers
 * @property boolean $total_questions
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $completed_on
 * @property-read \CertType $exam
 * @property-read \User $staff
 * @property-read \User $student
 * @property-read \Illuminate\Database\Eloquent\Collection|\Comment[] $comments
 * @method static \Illuminate\Database\Query\Builder|\Exam whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereExamId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereCid($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereReviewedBy($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereAssignedOn($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereCertId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereReviewed($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereWrongQuestions($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereWrongAnswers($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereTotalQuestions($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Exam whereCompletedOn($value) 
 * @method static \Exam reviewed() 
 * @method static \Exam notReviewed() 
 */
class Exam extends BaseModel {
    protected $dates = ['created_at', 'updated_at', 'assigned_on', 'completed_on'];
    protected $guarded = ['exam_id', 'reviewed'];
    protected $table = 'controller_exams';
    protected $with = ['student', 'comments'];
    static $rules = [
        'cid' => 'cid|integer',
        'reviewed_by' => '',
        'assigned_on' => 'date',
        'completed_on' => 'date',
        'cert_id' => 'integer',
        'reviewed' => 'integer',
        'correct' => 'integer',
        'wrong' => 'integer',
        'total_questions' => 'integer'
    ];

    public function getDates()
    {
        return $this->dates;
    }

    //relations
    public function cert()
    {
        return $this->hasOne('CertType', 'id', 'cert_type_id');
    }

    public function staff()
    {
        return $this->belongsTo('User', 'reviewed_by', 'cid');
    }

    public function student()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public function comments()
    {
        return $this->hasMany('Comment', 'parent_id', 'id');
    }

    //scopes
    public function scopeReviewed($query)
    {
        return $query->where('reviewed', '=', 1);
    }

    public function scopeNotReviewed($query)
    {
        return $query->where('reviewed', '=', 0);
    }

    //statics
    public static function recentExams($n)
    {
        return Exam::with(['student', 'staff', 'cert'])
            ->orderBy('created_at', 'desc')->where('reviewed', 0)->limit($n)->get();
    }
}
