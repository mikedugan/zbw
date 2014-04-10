<?php  namespace Zbw\Repositories; 

class QuestionsRepository
{
    public static function all()
    {
        return \ExamQuestion::all();
    }

    public static function add($i)
    {
        $q = new \ExamQuestion();
        $q->question = $i['question'];
        $q->correct = $i['correct'];
        $q->cert_type = $i['exam'];
        foreach(range('a','f') as $o)
        {
            if(isset($i['answer'.$o]))
            {
                $a = 'answer_' . $o;
                $q->$a = $i['answer'.$o];
            }
        }
        return $q->save();
    }
} 
