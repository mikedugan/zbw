<?php

use Zbw\Training\TrainingSessionRepository;
use Zbw\Training\ExamsRepository;
use Zbw\Users\UserRepository;

class TrainingController extends BaseController
{
    private $trainings;
    private $exams;
    private $users;

    function __construct(ExamsRepository $exams, TrainingSessionRepository $trainings, UserRepository $users)
    {
        $this->exams = $exams;
        $this->trainings = $trainings;
        $this->users = $users;
    }

    public function getIndex()
    {
        $data = [
            'availableExams' => $this->exams->availableExams(\Auth::user()->cid),
            'progress' => $this->users->trainingProgress(\Auth::user()->cid)
        ];
        return View::make('training.index', $data);
    }

    public function showAdmin($id)
    {
        $ts = $this->trainings->find($id, "all");
        $data = [
          'tsession' => $ts,
          'student'  => $ts->student,
          'staff'    => $ts->staff,
          'location' => $ts->facility
        ];
        return View::make('staff.training.session', $data);
    }

    public function getRequest()
    {
        $data = [
          'title'     => 'Request Training Session',
          'available' => $this->exams->availableExams(Auth::user()->cid)
        ];
        return View::make('training.request', $data);
    }

    public function showRequest($tid)
    {
        $request = \TrainingRequest::with(['student', 'certType', 'staff'])
                                   ->find($tid);
        $data = [
          'title'   => 'View Training Request',
          'request' => $request
        ];
        return View::make('training.show-request', $data);
    }

    public function getReview()
    {
        $exam = $this->exams->lastExam(Auth::user()->cid);
        $data = [
          'exam' => $exam
        ];
        if ( ! $exam) {
            return Redirect::back()->with('flash_info', 'No exams found');
        }
        return View::make('training.exams.review', $data);
    }

}
