<?php

use Zbw\Training\TrainingSessionGrader;
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
            'availableExams' => $this->exams->availableExams(\Sentry::getUser()->cid),
            'progress' => $this->users->trainingProgress(\Sentry::getUser()->cid)
        ];
        return View::make('training.index', $data);
    }

    public function showAdmin($id)
    {
        $ts = $this->trainings->get($id);
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
          'available' => $this->exams->availableExams(\Sentry::getUser()->cid)
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
        $exam = $this->exams->lastExam(\Sentry::getUser()->cid);
        $data = [
          'exam' => $exam
        ];
        if ( ! $exam) {
            return Redirect::back()->with('flash_info', 'No exams found');
        }
        return View::make('training.exams.review', $data);
    }

    public function getLiveSession($tsid)
    {
        $session = \TrainingRequest::find($tsid);
        $data = [
            'staff' => \Sentry::getUser(),
            'student' => \Sentry::getUser($session->cid)
        ];
        return View::make('staff.training.live', $data);
    }

    public function testLiveSession($tsid)
    {
        $request = \TrainingRequest::find($tsid);
        $data = [
            'staff' => \Sentry::getUser(),
            'student' => \Sentry::findUserById($request->cid),
            'facilities' => \TrainingFacility::all(),
            'types' => \TrainingType::all()
        ];
        return View::make('staff.training.live', $data);
    }

    public function postLiveSession($tsid)
    {
        $report = (new TrainingSessionGrader(\Input::all()))->fileReport();
        if($report instanceof \TrainingSession) {
            \TrainingRequest::complete($tsid);
            return Redirect::route('staff/training')->with('flash_success','Training session completed');
        } else {
            return Redirect::back()->with('flash_error', 'Error submitting training session! Please email admin@bostonartcc.net immediately');
        }
    }

}
