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
        $e->assigned_on = $i['assigned_on'];
        $e->cert_type_id = $i['cert_type_id'];
        $e->cid = $i['cid'];
        $e->total_questions = $i['total_questions'];
        if($this->checkAndSave($e)) { return $e; }
        else return false;
    }

    public function update($input)
    {

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
        return $this->make()->where('cid', $cid)->with(['student', 'comments', 'cert'])->latest()->first();
    }

    public function lastDay($cid)
    {
        return $this->make()->where('cid', $cid)->where('created_at', '>', \Carbon::yesterday());
    }

    public function finishReview($id)
    {
        $exam = \Exam::find($id);
        $exam->reviewed = 1;
        $exam->reviewed_by = \Sentry::getUser()->cid;
        return $this->checkAndSave($exam);
    }

    public function reopenReview($id)
    {
        $exam = \Exam::find($id);
        $exam->reviewed = 0;
        return$this->checkAndSave($exam);
    }

    public function indexPaginated($n = 10)
    {
        return $this->make()->with(['student', 'cert'])->paginate($n);
    }

    public function indexFiltered($input)
    {
        $ret = $this->make()->with(['student']);
        if(array_key_exists('initials', $input) && ! empty($input['initials'])) {
            $user = $this->users->findByInitials($input['initials']);
            $ret->where('cid', $user->cid);
        }
        if(array_key_exists('reviewed', $input) && $input['reviewed'] == 'true') {
            $ret->where('reviewed', '>=', 0);
        } else {
            $ret->where('reviewed', 0);
        }
        if(array_key_exists('before', $input) && ! empty($input['before'])) {
            $ret->where('completed_on', '<', \Carbon::createFromFormat('m-d-Y H:i:s', $input['before']));
        }
        if(array_key_exists('after', $input) && ! empty($input['after'])) {
            $ret->where('completed_on', '>', \Carbon::createFromFormat('m-d-Y H:i:s', $input['after']));
        }
        return $ret->get();
    }

    public function grade($input)
    {
        $exam = [];
        for($i = 1; $i < $input['examlength']; $i++) {
            $exam[$i] = [
                'id' => $input['question'.$i],
                'answer' => $input['answer'.$i]
            ];
        }
        $exam['examid'] = $input['examid'];

        $grader = new ExamGrader();
        return $grader->grade($exam);

    }
}
