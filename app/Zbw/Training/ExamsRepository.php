<?php namespace Zbw\Training;

use Zbw\Base\EloquentRepository;
use Zbw\Users\UserRepository;
use Zbw\Helpers;

class ExamsRepository extends EloquentRepository {

    public $model = '\Exam';
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function create($i)
    {
        $e = new \Exam();
        $e->assigned_on = \Carbon::now();
        $e->exam_id = $i['exam_id'];
        $e->cert_id = $i['cert_id'];
        $e->cid = $i['cid'];
        return $e->save;
    }

    public function update($input)
    {

    }

    public function get($id)
    {
        return $this->make()->find($id);
    }

    public function delete($eid)
    {

    }

    public function completeExam($wrong_q, $wrong_a)
    {
        //assign the wrong question and answer arrays to exam object
        foreach($wrong_q as $q)
        {
            $this->exam->wrong_questions .= $q.",";
        }
        foreach($wrong_a as $a)
        {
            $this->exam->wrong_answers .= $a.",";
        }

        $this->exam->total_questions = count($wrong_q);
    }

    /**
     * @param boolean training
     * @return string next available exam
     */
    public function availableExams($cid)
    {
        $user = $this->users->get($cid);
        $next = \CertType::find($user->certification->id + 1);
        return [$next->id, Helpers::readableCert($next->value)];
    }

    public function lastExam($cid)
    {
        return $this->make()->where('cid', $cid)->with(['student', 'comments'])->latest()->first();
    }
}
