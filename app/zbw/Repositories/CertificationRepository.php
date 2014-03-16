<?php namespace Zbw\Repositories;

use Zbw\Helpers;

class CertificationRepository {
    protected $exam;
    public function __construct($eid = false)
    {
        $this->exam = $eid ? \ControllerCert::find($eid) : null;
    }

    public function requestExam($cid)
    {
        $action = new \ActionRequired();
        $action->cid = $cid;
        $action->url = '/staff/exams/pending';
        $action->title = 'Exam Request';
        $action->description = "This is an automated notification. \r\n" .
            "$cid has requested the " . Helpers::readableCert(CertType::find($this->exam->exam_id)) . " exam.\r\n"
            . "All the best, \r\nBoston John";
        return $action->save();
    }

    public function assignExam($cid)
    {
        
    }
}
