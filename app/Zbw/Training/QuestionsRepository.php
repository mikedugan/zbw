<?php  namespace Zbw\Training;

use Zbw\Base\EloquentRepository;
use Zbw\Training\Contracts\QuestionsRepositoryInterface;

class QuestionsRepository extends EloquentRepository implements QuestionsRepositoryInterface
{
    public $model = "\\ExamQuestion";

    public function create($i)
    {
        $q = new \ExamQuestion();
        $q->question = $i['question'];
        $q->correct = $i['correct'];
        $q->cert_type_id = $i['exam'];
        $q->answer_a = $i['answera'];
        $q->answer_b = $i['answerb'];
        $q->answer_c = $i['answerc'];
        $q->answer_d = $i['answerd'];
        $q->answer_e = array_key_exists('answere', $i) ? $i['answere'] : null;
        $q->answer_f = array_key_exists('answerf', $i) ? $i['answerf'] : null;
        return $this->checkAndSave($q);
    }

    public function indexPaginated($n = 10)
    {
        return $this->make()->with(['exam'])->paginate($n);
    }

    public function indexFiltered($input)
    {
        if(array_key_exists('exam', $input)) {
            return $this->make()->with(['exam'])->where('cert_type_id', $input['exam'])->get();
        }
    }

    public function update($data) {}
} 
