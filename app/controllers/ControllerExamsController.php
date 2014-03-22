<?php

class ControllerExamsController extends BaseController {

    protected $er;
    public function __construct()
    {
        $this->er = new \Zbw\Repositories\ExamsRepository();
    }
	public function getStaffReview($eid)
    {
        $data = [
            'title' => 'Review Exam',
            'exam' => \ControllerExam::with(['student'])->find($eid)
        ];
        return View::make('staff.exams.review', $data);
    }

    public function getIntro($eid)
    {
        $data = [
            'title' => 'vZBW Exam Center'
        ];

        return View::make('training.exams.intro', $data);
    }

    public function getTake($eid)
    {
        $data = [
            'title' => 'Take Exam',
            'exam' => $this->er->get($eid)
        ];

        return View::make('training.exams.take', $data);
    }

    public function getQuestions()
    {
        $data = [
            'title' => 'vZBW Question Bank',
            'questions' =>
        ];
    }
}
