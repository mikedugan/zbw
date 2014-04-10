<?php 

class ExamQuestion extends Eloquent
{
    protected $table = '_exam_questions';
    public $timestamps = false;

    public function exam()
    {
        return $this->hasOne('CertType', 'id', 'cert_type');
    }

    public function scopeCs1($q)
    {
        return $q->where('cert_type','=',1);
    }

    public function scopeBs1($q)
    {
        return $q->where('cert_type','=',2);
    }

    public function scopeCs2($q)
    {
        return $q->where('cert_type', '=', 3);
    }

    public function scopeBs2($q)
    {
        return $q->where('cert_type', '=', 4);
    }

    public function scopeCs3($q)
    {
        return $q->where('cert_type', '=', 5);
    }

    public function scopeBs3($q)
    {
        return $q->where('cert_type', '=', 6);
    }

    public function scopeCenter($q)
    {
        return $q->where('cert_type', '=', 7);
    }
} 
