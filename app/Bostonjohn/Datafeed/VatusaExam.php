<?php  namespace Zbw\Bostonjohn\Datafeed; 

class VatusaExam 
{
    private $cid;
    private $exam;
    private $exam_date;
    private $exam_score;

    public function getCid()
    {
        return $this->cid;
    }

    public function getExam()
    {
        return $this->exam;
    }

    public function getExamDate()
    {
        return $this->exam_date;
    }

    public function getExamScore()
    {
        return $this->exam_score;
    }

    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    public function setExam($exam)
    {
        $this->exam = $exam;
    }

    public function setExamDate($exam_date)
    {
        $this->exam_date = $exam_date;
    }

    public function setExamScore($exam_score)
    {
        $this->exam_score = $exam_score;
    }
}
