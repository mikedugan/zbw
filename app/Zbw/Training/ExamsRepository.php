<?php namespace Zbw\Training;

use Zbw\Base\EloquentRepository;
use Zbw\Base\Helpers;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Training\Contracts\ExamsRepositoryInterface;

class ExamsRepository extends EloquentRepository implements ExamsRepositoryInterface
{

    public $model = '\Exam';
    protected $users;

    public function __construct(UserRepositoryInterface $users)
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
        return $this->checkAndSave($e);
    }

    public function update($input)
    {

    }

    public function get($id, $withTrashed = false)
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
