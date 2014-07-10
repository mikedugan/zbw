<?php namespace Zbw\Training;

use Zbw\Base\Helpers;
use Zbw\Base\EloquentRepository;
use Zbw\Training\Contracts\CertificationRepositoryInterface;

class CertificationRepository extends EloquentRepository implements CertificationRepositoryInterface
{
    protected $exams;
    public $model = 'Certification';
    public function __construct(ExamsRepositoryInterface $exams)
    {
        $this->exams = $exams;
    }

    public function update($input)
    {

    }

    public function create($input)
    {

    }

    public function requestExam($cid, $eid)
    {
        $action = new \ActionRequired();
        $action->cid = $cid;
        $action->url = '/staff/exams/pending';
        $action->title = 'Exam Request';
        $action->description = "This is an automated notification. \r\n" .
          "$cid has requested the " . Helpers::readableCert(
            CertType::find($eid->exam_id)
          ) . " exam.\r\n"
          . "All the best, \r\nBoston John";
        return $action->save();
    }

    public function assignExam($cid)
    {
        $e = $this->exams->create($cid);
        \PendingExam::create(
          ['exam_id' => $e->id, 'cert_id' => $this->exam->id, 'cid' => $cid]
        );
    }
}
