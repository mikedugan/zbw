<?php

use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Training\TrainingSessionGrader;
use Zbw\Training\Contracts\TrainingSessionRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

class TrainingController extends BaseController
{
    private $trainings;
    private $exams;
    private $users;

    function __construct(ExamsRepositoryInterface $exams, TrainingSessionRepositoryInterface $trainings, UserRepositoryInterface $users)
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

    public function getAdminIndex()
    {
        $data = [
          'reports' => $this->trainings->recentReports(10),
          'sessions' => ['a', 'b'],
          'requests' => \TrainingRequest::with(['student', 'certType'])->orderBy('created_at', 'desc')->limit(10)->get(),
          'exams' => \Exam::recentExams(10),
          'staffings' => \Staffing::limit(10)->with(['user'])->orderBy('created_at', 'DESC')->get()
        ];
        return View::make('staff.training.index', $data);
    }

    public function showAdmin($id)
    {
        $ts = $this->trainings->with(['student', 'staff', 'facility', 'weatherType', 'trainingReport'], $id);
        $data = [
          'tsession' => $ts
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
            \TrainingRequest::complete($tsid, $report->id);
            return Redirect::route('staff/training')->with('flash_success','Training session completed');
        } else {
            return Redirect::back()->with('flash_error', 'Error submitting training session! Please email admin@bostonartcc.net immediately');
        }
    }

}
