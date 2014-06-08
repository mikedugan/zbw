<?php

class Exam extends Eloquent {
    protected $guarded = ['exam_id', 'reviewed'];
    protected $table = 'controller_exams';
    public $rules;



    //relations
    public function exam()
    {
        return $this->hasOne('CertType', 'id', 'exam_id');
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
