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
        $student = \Sentry::getUser();
        $reviews = $student->exams()->where('reviewed', 0)->get();
        if(in_array($student->cert, [2,5,8,10])) { $reviews = 1; }
        $data = [
            'availableExams' => $this->exams->availableExams(\Sentry::getUser()->cid),
            'progress' => $this->users->trainingProgress(\Sentry::getUser()->cid),
            'review' => count($reviews) > 0 ? true : false,
            'canTake' => count($student->exams) == 0 || $this->exams->lastExam($student->cid)->reviewed == 1 ? true : false
        ];
        return View::make('training.index', $data);
    }

    public function getAdminIndex()
    {
        $this->setData('reports', $this->trainings->recentReports(10));
        $this->setData('exams', $this->exams->recentExams(10));
        $this->setData('staffings', \Staffing::recentStaffings(10));
        $this->setData('requests', \TrainingRequest::with(['student', 'certType'])->orderBy('created_at', 'desc')->limit(10)->get());
        $this->view('staff.training.index');
    }

    //all training reports
    public function getAll()
    {
        if(\Input::has('sinitials') || \Input::has('before') || \Input::has('after') || \Input::has('cinitials')) {
            $data = [
                'sessions' => $this->trainings->indexFiltered(\Input::all()),
                'paginate' => false
            ];
        }
        else {
            $data = [
                'sessions' => $this->trainings->indexPaginated(10),
                'paginate' => true
            ];
        }
        return View::make('staff.training.all', $data);
    }

    //all training requests
    public function getAllRequests()
    {
        if(\Input::has('initials') || \Input::has('before') || \Input::has('after')) {
            $data = [
                'requests' => \TrainingRequest::indexFiltered(\Input::all()),
                'paginate' => false
            ];
        }
        else {
            $data = [
                'requests' => \TrainingRequest::indexPaginated(10),
                'paginate' => true
            ];
        }
        return View::make('staff.training.all-requests', $data);
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
        $user = \Sentry::getUser();
        if($user->cert == 0 || $user->cert == 1) {
            return Redirect::route('training')->with('flash_error', 'You must pass the ZBW class C ground exam to request training!');
        }
        return View::make('training.request');
    }

    public function showRequest($tid)
    {
        $request = \TrainingRequest::with(['student', 'certType', 'staff'])
                                   ->find($tid);
        $data = [
          'request' => $request
        ];
        return View::make('training.show-request', $data);
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

    public function getAdopt($cid)
    {
        $data = [
            'student' => $this->users->get($cid)
        ];

        return View::make('staff.training.adopt', $data);
    }

    public function postAdopt()
    {
        $input = \Input::all();
        if($this->users->adopt($input['student'], \Sentry::getUser()->cid)) {
            $input['staff'] = \Sentry::getUser()->cid;
            Queue::push('Zbw\Bostonjohn\Queues\QueueDispatcher@usersAdopt', $input);
            return Redirect::back()->with('flash_success', 'User adopted successfully!');
        } else {
            return Redirect::back()->with('flash_error', $this->users->getErrors());
        }
    }

    public function postDropAdopt($cid)
    {
        if($this->users->dropAdopt($cid)) {
            return Redirect::back()->with('flash_success', 'Adoption dropped successfully');
        } else {
            return Redirect::back()->with('flash_error', $this->users->getErrors());
        }
    }

}
