<?php

class Exam extends BaseModel {
    protected $guarded = ['exam_id', 'reviewed'];
    protected $table = 'controller_exams';
    protected $with = ['student', 'comments'];
    static $rules = [
        'exam_id' => 'integer',
        'cid' => 'cid|integer',
        'reviewed_by' => 'cid|integer',
        'assigned_on' => 'date',
        'completed_on' => 'date',
        'cert_id' => 'integer',
        'reviewed' => 'integer',
        'wrong_questions' => '',
        'wrong_answers' => '',
        'total_questions' => 'integer'
    ];

    public function getDates()
    {
        return ['assigned_on'];
    }

    //relations
    public function exam()
    {
        return $this->hasOne('CertType', 'id', 'cert_id');
    }

    public function reviewer()
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
        return Exam::with(['student', 'reviewer', 'exam'])
            ->orderBy('created_at', 'desc')->where('reviewed', '=', 0)->limit($n)->get();
    }
}
