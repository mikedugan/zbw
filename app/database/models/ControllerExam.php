<?php

class ControllerExam extends Eloquent {
    protected $guarded = ['exam_id', 'reviewed'];
    protected $table = 'controller_exams';
    public $rules;

    public function __construct()
    {
        $cids = \Zbw\Helpers::getCids(true);
        $this-> rules = [
            'exam_id' => 'between:1,10',
            'total_questions' => 'integer',
            'cid' => 'in:' . $cids,
            'reviewed_by' => 'in:' . $cids
        ];
    }

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
        return ControllerExam::with(['student', 'reviewer', 'exam'])
            ->limit($n)->orderBy('created_at', 'desc')->where('reviewed', '=', 0)->get();
    }
}
