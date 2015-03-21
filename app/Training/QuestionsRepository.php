<?php  namespace Zbw\Training;

use Zbw\Core\EloquentRepository;
use Zbw\Training\Contracts\QuestionsRepositoryInterface;

class QuestionsRepository extends EloquentRepository implements QuestionsRepositoryInterface
{
    public $model = "\\ExamQuestion";

    public function create($i)
    {
        $q = new \ExamQuestion();
        $this->fill($q, $i);
        return $this->checkAndSave($q);
    }

    private function fill($q, $i)
    {
        $q->question = $i['question'];
        $q->correct = $i['correct'];
        $q->cert_type_id = $i['exam'];
        $q->answer_a = $i['answera'];
        $q->answer_b = $i['answerb'];
        $q->answer_c = $i['answerc'];
        $q->answer_d = $i['answerd'];
        $q->answer_e = array_key_exists('answere', $i) ? $i['answere'] : null;
        $q->answer_f = array_key_exists('answerf', $i) ? $i['answerf'] : null;
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

    public function update($i)
    {
        $q = $this->get($i['id']);
        $this->fill($q, $i);
        return $this->checkAndSave($q);
    }

    public function exam($cert_id, $count)
    {
        $questions = [];
        $set = $this->make()->where('cert_type_id', $cert_id)->get();
        while(count($questions) < $count) {
            $index = mt_rand(0, count($set) - 1);
            if(array_key_exists($index, $questions)) continue;
            else $questions[$index] = $set[$index];
        }

        return $questions;
    }
} 
