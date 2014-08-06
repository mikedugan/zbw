<?php 

/**
 * ExamQuestion
 *
 * @property integer $id
 * @property boolean $cert_type_id
 * @property string $question
 * @property string $answer_a
 * @property string $answer_b
 * @property string $answer_c
 * @property string $answer_d
 * @property string $answer_e
 * @property string $answer_f
 * @property boolean $correct
 * @property-read \CertType $exam
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereCertTypeId($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereQuestion($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereAnswerA($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereAnswerB($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereAnswerC($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereAnswerD($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereAnswerE($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereAnswerF($value) 
 * @method static \Illuminate\Database\Query\Builder|\ExamQuestion whereCorrect($value) 
 * @method static \ExamQuestion cs1() 
 * @method static \ExamQuestion bs1() 
 * @method static \ExamQuestion cs2() 
 * @method static \ExamQuestion bs2() 
 * @method static \ExamQuestion cs3() 
 * @method static \ExamQuestion bs3() 
 * @method static \ExamQuestion center() 
 */
class ExamQuestion extends BaseModel
{
    protected $table = '_exam_questions';
    public $timestamps = false;
    static $rules = [
        'question' => 'required',
        'cert_type_id' => 'required|integer'
    ];

    public function exam()
    {
        return $this->hasOne('CertType', 'id', 'cert_type_id');
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
