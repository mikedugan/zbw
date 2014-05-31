<?php namespace Zbw\Training;

use Zbw\Bostonjohn\ZbwLog;
use Zbw\Users\UserRepository;
use Zbw\Helpers;
use Zbw\Interfaces\EloquentRepositoryInterface;

class ExamsRepository implements EloquentRepositoryInterface {

    public static function all()
    {
        return \ControllerExam::all();
    }

    public static function add($i)
    {
        $e = new \ControllerExam();
        $e->assigned_on = \Carbon::now();
        $e->exam_id = $i['exam_id'];
        $e->cert_id = $i['cert_id'];
        $e->cid = $i['cid'];
        return $e->save;
    }

    public static function find($id, $relations)
    {

    }

    public static function delete($eid)
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
    public static function availableExams($cid)
    {
        $user = UserRepository::find($cid);
        $next = \CertType::find($user->certification->id + 1);
        return [$next->id, Helpers::readableCert($next->value)];
    }

    public static function lastExam($cid)
    {
        return \ControllerExam::where('cid', $cid)->with(['student', 'comments'])->latest()->first();
    }
}
