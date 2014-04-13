<?php namespace Zbw\Repositories;

use Zbw\Bostonjohn\ZbwLog;

class ExamsRepository {
    protected $exam;
    protected $log;
    public function __construct($eid = null)
    {
        $this->exam = $eid ? \ControllerExam::find($eid) : null;
        $this->log = new ZbwLog();
    }

    public function all()
    {
        return \ControllerExam::all();
    }

    public function add($i)
    {
        $e = new \ControllerExam();
        $e->assigned_on = \Carbon::now();
        $e->exam_id = $i['exam_id'];
        $e->cert_id = $i['cert_id'];
        $e->cid = $i['cid'];
        if($e->save())
        {
            $name = \User::find($i['cid']);
            $this->log->addLog(Auth::user()->initials . " assigned exam to $name", 'exam');
            return true;
        }

        return false;
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
        $user = UserRepository::find($cid);
        $next = \CertType::find($user->certification->id + 1);
        return [$next->id, Helpers::readableCert($next->value)];
    }
}
