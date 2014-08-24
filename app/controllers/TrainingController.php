<?php

use Illuminate\Session\Store;
use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Training\Contracts\TrainingSessionRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

use Zbw\Training\Commands\ProcessTrainingSessionCommand;

class TrainingController extends BaseController
{
    private $trainings;
    private $exams;
    private $users;

    function __construct(ExamsRepositoryInterface $exams, TrainingSessionRepositoryInterface $trainings, UserRepositoryInterface $users, Store $session)
    {
        $this->exams = $exams;
        $this->trainings = $trainings;
        $this->users = $users;
        parent::__construct($session);
    }

    public function getIndex()
    {
        $reviews = $this->current_user->exams()->where('reviewed', 0)->get();
        if(in_array($this->current_user->cert, [2,5,8,10])) { $reviews = 1; }
        $this->setData('availableExams', $this->exams->availableExams(\Sentry::getUser()->cid));
        $this->setData('progress', $this->users->trainingProgress(\Sentry::getUser()->cid));
        $this->setData('review', count($reviews) > 0 ? true : false);
        $this->setData('canTake', count($this->current_user->exams) == 0 || $this->exams->lastExam($this->current_user->cid)->reviewed == 1 ? true : false);

        $this->view('training.index');
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
        if(empty(\Input::all())) {
            $this->setData('sessions', $this->trainings->indexPaginated(10));
            $this->setData('paginate', true);
        } else {
            $this->setData('sessions', $this->trainings->indexFiltered(\Input::all()));
            $this->setData('paginate', false);
        }

        $this->view('staff.training.all');
    }

    //all training requests
    public function getAllRequests()
    {
        if(empty(\Input::all())) {
            $this->setData('requests', \TrainingRequest::indexPaginated(10));
            $this->setData('paginate', false);
        } else {
            $this->setData('requests', \TrainingRequest::indexFiltered(\Input::all()));
            $this->setData('paginate', true);
        }

        $this->view('staff.training.all-requests');
    }

    public function showAdmin($id)
    {
        $this->setData('tsession', $this->trainings->with(['student', 'staff', 'facility', 'weatherType', 'trainingReport'], $id));
        $this->view('staff.training.session');
    }

    public function getRequest()
    {
        if($this->current_user->cert == 0 <= 1) {
            $this->setFlash(['flash_error' => 'You must pass the ZBW class C ground exam to request training!']);
            $this->redirectRoute('training');
        }

        $this->view('training.request');
    }

    public function showRequest($tid)
    {
        $this->setData('request', \TrainingRequest::with(['student', 'certType', 'staff'])->find($tid));
        $this->view('training.show-request');
    }

    public function getLiveSession($tsid)
    {
        $this->setData('student', \TrainingRequest::find($tsid)->cid);
        $this->setData('staff', $this->current_user);
        $this->view('staff.training.live');
    }

    public function testLiveSession($tsid)
    {
        $request = \TrainingRequest::find($tsid);
        $this->setData('staff', $this->current_user);
        $this->setData('student', $this->users->get($request->cid));
        $this->setData('facilities', \TrainingFacility::all());
        $this->setData('types', \TrainingType::all());
        $this->view('staff.training.live');
    }

    public function postLiveSession($tsid)
    {
        $success = $this->execute(ProcessTrainingSessionCommand::class, ['input' => \Input::all(), 'tsid' => $tsid]);

        if($success) {
            $this->setFlash(['flash_success' => 'Training session completed']);
            return $this->redirectRoute('staff/training');
        } else {
            $this->setFlash(['flash_error' => 'Error submitting training session! Please email admin@bostonartcc.net immediately']);
            return $this->redirectBack()->withInput();
        }
    }

    public function getAdopt($cid)
    {
        $this->setData('student', $this->users->get($cid));
        $this->view('staff.training.adopt');
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
