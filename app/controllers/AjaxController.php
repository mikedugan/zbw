<?php

use Illuminate\Session\Store;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Core\Repositories\RatingRepository;
use Zbw\Notifier\Mail;
use Zbw\Training\Contracts\CertificationRepositoryInterface;
use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Training\TrainingRequestRepository;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

use Zbw\Users\Commands\AcceptVisitorCommand;

class AjaxController extends BaseController
{
    /**
     * @var UserRepositoryInterface
     */
    private $users;
    /**
     * @var MessagesRepositoryInterface
     */
    private $messages;
    /**
     * @var Mail
     */
    private $emailer;
    /**
     * @var CertificationRepositoryInterface
     */
    private $certs;
    /**
     * @var VisitorApplicantRepositoryInterface
     */
    private $visitors;

    /**
     * @var TrainingRequestRepository
     */
    private $requests;

    /**
     * @param UserRepositoryInterface             $users
     * @param MessagesRepositoryInterface         $messages
     * @param Mail                                $emailer
     * @param CertificationRepositoryInterface    $certs
     * @param ExamsRepositoryInterface            $exams
     * @param TrainingRequestRepository           $requests
     * @param VisitorApplicantRepositoryInterface $visitors
     * @param Store                               $session
     */
    public function __construct(UserRepositoryInterface $users,
        MessagesRepositoryInterface $messages,
        Mail $emailer,
        CertificationRepositoryInterface $certs,
        ExamsRepositoryInterface $exams,
        TrainingRequestRepository $requests,
        VisitorApplicantRepositoryInterface $visitors,
        Store $session)
    {
        $this->users = $users;
        $this->messages = $messages;
        $this->emailer = $emailer;
        $this->certs = $certs;
        $this->exams = $exams;
        $this->visitors = $visitors;
        $this->requests = $requests;
        parent::__construct($session);
    }

    //handles an ajax request
    /**
     * @param $cid
     * @param $eid
     * @return string
     */
    public function requestExam($cid, $eid)
    {
        if ($this->certs->requestExam($cid, $eid)) {
            return $this->json(['success' => true,'message' => 'Your exam has been successfully requested!']);
        } else {
            return $this->json(['success' => false,'message' => 'There was an error! Please contact a staff member!']);
        }
    }

    /**
     * @param $cid
     * @return string
     */
    public function sendStaffWelcome($cid)
    {
        $this->emailer->staffWelcomeEmail($cid);

        return $this->json(['success' => true, 'message' => "Staff welcome email sent successfully!"]);
    }

    /**
     * @param $id
     * @return string
     */
    public function suspendUser($id)
    {
        if ($this->users->suspendUser($id)) {
            return $this->json(['success' => true, 'message' => 'User suspended']);
        } else {
            return $this->json(['success' => false,'message' => 'Error suspending user']);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function terminateUser($id)
    {
        if ($this->users->terminateUser($id)) {
            return $this->json(['success' => true,'message' => 'User terminated']);
        } else {
            return $this->json(['success' => false,'message' => 'Error terminating user']);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function activateUser($id)
    {
        \Log::debug('activating ' . $id);
        if ($this->users->activateUser($id)) {
            return $this->json(['success' => true,'message' => 'User activated']);
        } else {
            return $this->json(['success' => false,'message' => 'Error activating user']);
        }
    }

    /**
     * @return string
     */
    public function postTrainingRequest()
    {
        try {
            if($this->requests->create(\Input::all())) {
                return $this->json(['success' => true,'message' => 'Training request added successfully']);
            } else {
                return $this->json(['success'  => false,'messaage' => 'Error sending training request!']);
            }
        } catch(InvalidArgumentException $e) {
            return $this->json(['success' => false,'message' => \Input::get('start')]);
        }
    }

    /**
     * @param $tsid
     * @throws Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelTrainingRequest($tsid)
    {
        if ($this->requests->delete($tsid)) {
            return Redirect::home()->with('flash_success', 'Training session cancelled');
        } else {
            return Redirect::back()->with('flash_error', 'Unable to cancel session');
        }
    }

    /**
     * @param $tsid
     * @return string
     */
    public function acceptTrainingRequest($tsid)
    {
        if ($this->requests->accept($tsid, $this->current_user->cid, \Input::all())) {
            return $this->json(['success' => true,'message' => 'Training session accepted. Page reload in 2 seconds...']);
        } else {
            return $this->json(['success' => false,'message' => 'Error accepting training session.']);
        }
    }

    /**
     * @param $tid
     * @return string
     */
    public function dropTrainingRequest($tid)
    {
        if ($this->requests->drop($tid, \Sentry::getUser()->cid)) {
            return $this->json(['success' => true,'message' => 'Training session dropped.']);
        } else {
            return $this->json(['success' => false,'message' => 'Unable to drop training session']);
        }
    }

    /**
     * @return string
     */
    public function markInboxRead()
    {
        if ($this->messages->markAllRead(\Sentry::getUser()->cid)) {
            return $this->json(['success' => true,'message' => 'All messaged marked as read']);
        } else {
            return $this->json(['success' => false,'message' => 'Error marking messages read']);
        }
    }

    /* @param $id
     * @return string
     */
    public function postExamReviewed($id)
    {
        if ($this->exams->finishReview($id)) {
            return $this->json(['success' => true,'message' => 'Exam review complete.']);
        } else {
            return $this->json(['success' => false,'message' => implode(',', $this->exams->getErrors())]);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function postReopenExam($id)
    {
        if ($this->exams->reopenReview($id)) {
            return $this->json(['success' => true,'message' => 'Exam review reopened.']);
        } else {
            return $this->json(['success' => false,'message' => $this->exams->getErrors()]);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function postVisitorAccept($id)
    {
        $response = $this->execute(AcceptVisitorCommand::class, ['cid' => $id, 'sid' => $this->current_user->cid]);
        if($response === true) {
            return $this->json(['success' => true,'message' => 'Visitor application accepted.']);
        } else {
            return $this->json(['success' => false,'message' => implode(',', $this->visitors->getErrors())]);
        }
    }

    /**
     * @return string
     */
    public function requestVatusaExam()
    {
        $ratings = new RatingRepository();
        $exam = $ratings->get($this->current_user->rating_id + 1)->long;
        Queue::push('Zbw\Queues\QueueDispatcher@usersRequestVatusaExam', $this->current_user->cid);
        return $this->json(['success' => true,'message' => 'VATUSA '.$exam.' exam requested.']);
    }

    public function promoteUser($cid)
    {
        \Queue::push('Zbw\Queues\QueueDispatcher@usersPromote', $cid);
        return $this->json(['success' => true,'message' => 'User promoted']);
    }

    public function demoteUser($cid)
    {
        \Queue::push('Zbw\Queues\QueueDispatcher@usersDemote', $cid);
        return $this->json(['success' => true,'message' => 'User demoted']);
    }
}
