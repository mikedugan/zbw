<?php namespace Zbw\Http\Controllers;

use Illuminate\Session\Store;
use TrainingRequest;
use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Training\Contracts\TrainingSessionRepositoryInterface;
use Zbw\Training\TrainingRequestRepository;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Training\Contracts\StaffAvailabilityRepositoryInterface;

use Zbw\Training\Commands\ProcessTrainingSessionCommand;
use Zbw\Training\Commands\AdoptUserCommand;

class TrainingController extends BaseController
{
    private $trainings;
    private $exams;
    private $requests;
    private $users;
    private $staffAvailability;

    public function __construct(
        ExamsRepositoryInterface $exams,
        TrainingSessionRepositoryInterface $trainings,
        TrainingRequestRepository $requests,
        StaffAvailabilityRepositoryInterface $staffAvailability,
        UserRepositoryInterface $users,
        Store $session
    ) {
        $this->exams = $exams;
        $this->trainings = $trainings;
        $this->requests = $requests;
        $this->users = $users;
        $this->staffAvailability = $staffAvailability;
        parent::__construct($session);
    }

    public function getIndex()
    {
        //$this->setData('availableExams', $this->exams->availableExams($this->current_user->cid));
        $this->setData('progress', $this->users->trainingProgress($this->current_user->cid));
        $this->setData('student', $this->current_user);
        $this->setData('available', $this->staffAvailability->upcoming(10));
        $this->setData('requests', $this->requests->getCurrentByCid($this->current_user->cid));
        $this->setData('ratings', \Rating::all());
        $this->setData('certifications', \CertType::all());
        return $this->view('training.index');
    }

    public function getAdminIndex()
    {
        $this->setData('reports', $this->trainings->recentReports(10));
        $this->setData('exams', $this->exams->recentExams(10));
        $this->setData('staffings', \Staffing::recentStaffings(10));
        $this->setData('requests', $this->requests->getRecent(10));
        return $this->view('staff.training.index');
    }

    //all training reports
    public function getAll()
    {
        if (empty($this->request->all())) {
            $this->setData('sessions', $this->trainings->indexPaginated(10));
            $this->setData('paginate', true);
        } else {
            $this->setData('sessions', $this->trainings->indexFiltered($this->request->all()));
            $this->setData('paginate', false);
        }

        return $this->view('staff.training.all');
    }

    //all training requests
    public function getAllRequests()
    {
//        if(empty($this->request->all())) {
//            $this->setData('requests', $this->requests->indexPaginated(10));
//            $this->setData('paginate', false);
//        } else {
//            $this->setData('requests', $this->requests->indexFiltered($this->request->all()));
//            $this->setData('paginate', true);
//        }
        $this->setData('paginate', false);
        $this->setData('requests', $this->requests->all());

        return $this->view('staff.training.all-requests');
    }

    public function showAdmin($id)
    {
        $this->setData('tsession',
            $this->trainings->with(['student', 'staff', 'facility', 'weatherType', 'trainingReport'], $id));
        return $this->view('staff.training.session');
    }

    public function getRequest()
    {
        if ($this->current_user->cert == 0) {
            $this->setFlash(['flash_error' => 'You must pass the ZBW class C ground exam to request training!']);
            $this->redirectRoute('training');
        }

        $this->setData('available', $this->staffAvailability->upcoming(10));
        return $this->view('training.request');
    }

    public function getNewSession()
    {
        return $this->view('staff.training.new');
    }

    public function postNewSession()
    {
        if (! $this->request->has('student')) {
            return $this->redirectBack()->with('flash_error', 'Please enter initials or CID');
        }
        $student = $this->request->get('student');

        if (is_int($student) && ! $this->users->exists($student)) {
            return $this->redirectBack()->with('flash_error', 'Controller does not exist');
        } else {
            if (! $this->users->findByInitials($student)) {
                return $this->redirectBack()->with('flash_error', 'Controller does not exist');
            }
        }

        if (is_int($student)) {
            $student = $this->users->get($student);
        } else {
            $student = $this->users->findByInitials($student);
        }

        $tr = new TrainingRequest();
        $tr->cid = $student->cid;
        $tr->sid = $this->current_user->cid;
        $tr->cert_id = $student->cert + 1;
        $tr->accepted_by = $tr->sid;
        $tr->start = \Carbon\Carbon::now();
        $tr->end = \Carbon\Carbon::now();
        $tr->comment = '';
        $tr->save();

        return $this->redirectTo('/staff/live/' . $tr->id);
    }

    public function showRequest($tid)
    {
        $this->setData('request', $this->requests->getWithAll($tid));
        return $this->view('training.show-request');
    }

    public function getLiveSession($tsid)
    {
        $this->setData('student', $this->requests->get($tsid)->cid);
        $this->setData('staff', $this->current_user);
        return $this->view('staff.training.live');
    }

    public function testLiveSession($tsid)
    {
        $request = $this->requests->get($tsid);
        $this->setData('staff', $this->current_user);
        $this->setData('student', $this->users->get($request->cid));
        $this->setData('facilities', \TrainingFacility::all());
        $this->setData('types', \TrainingType::all());
        return $this->view('staff.training.live');
    }

    public function postLiveSession($tsid)
    {
        $success = $this->execute(ProcessTrainingSessionCommand::class,
            ['input' => $this->request->all(), 'tsid' => $tsid]);

        if ($success) {
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
        return $this->view('staff.training.adopt');
    }

    public function postAdopt()
    {
        $input = $this->request->only(['meeting', 'message', 'subject', 'sid', 'cid']);
        $success = $this->execute(AdoptUserCommand::class, $input);

        if ($success === true) {
            $this->setFlash(['flash_success' => 'User adopted successfully']);
        } else {
            $this->setFlash(['flash_error' => $success]);
        }

        return $this->redirectBack();
    }

    public function postDropAdopt($cid)
    {
        if ($this->users->dropAdopt($cid)) {
            $this->setFlash(['flash_success' => 'Adoption dropped successfully']);
        } else {
            $this->setFlash(['flash_error' => $this->users->getErrors()]);
        }
        return $this->redirectBack();
    }

    public function viewSession($id)
    {
        $session = $this->trainings->get($id);
        if ($this->current_user->cid !== $session->cid) {
            return $this->redirectRoute('training');
        } else {
            $this->setData('tsession', $session);
            return $this->view('training.session');
        }
    }

    public function getStaffStaffAvailability()
    {
        $this->setData('available', $this->staffAvailability->all());
        return $this->view('staff.training.availability');
    }

    public function postStaffAvailability()
    {
        $input = $this->request->all();
        $input['cid'] = $this->current_user->cid;
        $this->staffAvailability->create($input);
        $this->setFlash(['flash_success' => 'Availability posted successfully']);
        return $this->redirectBack();
    }

    public function getDeleteAvailability($id)
    {
        $session = $this->staffAvailability->get($id);
        if ($session->cid !== $this->current_user->cid) {
            $this->setFlash(['flash_error' => 'Operation not allowed']);
        } else {
            $this->staffAvailability->delete($id);
            $this->setFlash(['flash_success' => 'Availability deleted successfully']);
        }

        return $this->redirectBack();
    }

    public function postCancelRequest($id)
    {
        $request = $this->requests->get($id);
        if ($request->cid === $this->current_user->cid) {
            $request->is_cancelled = 1;
            $request->save();
        }

        return $this->redirectBack()->with('flash_success', 'Training request cancelled');
    }

}
