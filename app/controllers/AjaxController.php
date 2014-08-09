<?php

use Zbw\Bostonjohn\Notifier;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Training\Contracts\CertificationRepositoryInterface;
use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

class AjaxController extends BaseController
{
    private $users;
    private $messages;
    private $emailer;
    private $certs;
    private $visitors;

    public function __construct(UserRepositoryInterface $users, MessagesRepositoryInterface $messages, Notifier $emailer, CertificationRepositoryInterface $certs, ExamsRepositoryInterface $exams, VisitorApplicantRepositoryInterface $visitors)
    {
        $this->users = $users;
        $this->messages = $messages;
        $this->emailer = $emailer;
        $this->certs = $certs;
        $this->exams = $exams;
        $this->visitors = $visitors;
    }

    //handles an ajax request
    public function requestExam($cid, $eid)
    {
        if ($this->certs->requestExam($cid, $eid)) {
            return json_encode(
              ['success' => true,
               'message' => 'Your exam has been successfully requested!']
            );
        } else {
            return json_encode(
              ['success' => false,
               'message' => 'There was an error! Please contact a staff member!']
            );
        }
    }

    /*    public function actionCompleted($aid)
        {
            $ar = new ActionRepository($aid);
            if($ar->resolve())
                return json_encode(['success' => true, 'message' => 'Notification marked completed!']);
            else return json_encode(['success' => false, 'message' => 'Notification could not be resolved!']);
        }*/

    public function sendStaffWelcome($cid)
    {
        $em = new Notifier(\Sentry::getUser()->cid);
        $em->staffWelcome();

        return json_encode(['success' => true, 'message' => "Staff welcome email sent successfully!"]);
    }

    public function suspendUser($id)
    {
        if ($this->users->suspendUser($id)) {
            return json_encode([
              'success' => true,
              'message' => 'User suspended'
            ]);
        } else {
            return json_encode([
              'success' => false,
              'message' => 'Error suspending user'
            ]);
        }
    }

    public function terminateUser($id)
    {
        if ($this->users->terminateUser($id)) {
            return json_encode([
              'success' => true,
              'message' => 'User terminated'
            ]);
        } else {
            return json_encode([
              'success' => false,
              'message' => 'Error terminating user'
            ]);
        }
    }

    public function activateUser($id)
    {
        if ($this->users->activateUser($id)) {
            return json_encode([
              'success' => true,
              'message' => 'User activated'
            ]);
        } else {
            return json_encode([
              'success' => false,
              'message' => 'Error activating user'
            ]);
        }
    }

    public function postTrainingRequest()
    {
        try {
            if (\TrainingRequest::create(\Input::all())) {
                return json_encode(
                  [
                    'success' => true,
                    'message' => 'Training request added successfully'
                  ]
                );
            } else {
                return json_encode(
                  [
                    'success'  => false,
                    'messaage' => 'Error sending training request!'
                  ]
                );
            }
        } catch(InvalidArgumentException $e) {
            return json_encode(
              [
                'success' => false,
                'message' => \Input::get('start')
              ]
            );
        }
    }

    public function cancelTrainingRequest($tsid)
    {
        $tr = TrainingRequest::find($tsid);
        if ($tr->delete()) {
            return Redirect::home()->with('flash_success', 'Training session cancelled');
        } else {
            return Redirect::back()->with('flash_error', 'Unable to cancel session');
        }
    }

    public function acceptTrainingRequest($tsid)
    {
        if (\TrainingRequest::accept($tsid, \Sentry::getUser()->cid)) {
            return json_encode([
              'success' => true,
              'message' => 'Training session accepted'
            ]);
        } else {
            return json_encode([
              'success' => false,
              'message' => 'Error accepting training session'
            ]);
        }
    }

    public function dropTrainingRequest($tid)
    {
        if (\TrainingRequest::drop($tid, \Sentry::getUser()->cid)) {
            return json_encode(
              [
                'success' => true,
                'message' => 'Training session dropped'
              ]
            );
        } else {
            return json_encode([
              'success' => false,
              'message' => 'Unable to drop training session'
            ]);
        }
    }

    public function markInboxRead()
    {
        if ($this->messages->markAllRead(\Sentry::getUser()->cid)) {
            return json_encode([
              'success' => true,
              'message' => 'All messaged marked as read'
            ]);
        } else {
            return json_encode([
              'success' => false,
              'message' => 'Error marking messages read'
            ]);
        }
    }

    public function postExamReviewed($id)
    {
        if ($this->exams->finishReview($id)) {
            return json_encode([
              'success' => true,
              'message' => 'Exam review complete. Page reloading in 3 seconds...'
            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => implode(',', $this->exams->getErrors())
            ]);
        }
    }

    public function postReopenExam($id)
    {
        if ($this->exams->reopenReview($id)) {
            return json_encode([
              'success' => true,
              'message' => 'Exam review reopened. Page reloading in 3 seconds...'
            ]);
        } else {
            return json_encode([
              'success' => false,
              'message' => $this->exams->getErrors()
            ]);
        }
    }

    public function postVisitorAccept($id)
    {
        $staff = \Sentry::getUser();
        if($this->visitors->accept($staff, $id)) {
            Queue::push('Zbw\Bostonjohn\QueueDispatcher@usersAcceptVisitor', $id);
            return json_encode([
              'success' => true,
              'message' => 'Visitor application accepted. Page reloading in 3 seconds...'
            ]);
        } else {
            return json_encode([
              'success' => false,
              'message' => implode(',', $this->visitors->getErrors())
            ]);
        }
    }
}
