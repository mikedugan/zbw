<?php 

use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Bostonjohn\Notifier;
use Zbw\Training\Contracts\CertificationRepositoryInterface;

class AjaxController extends BaseController
{
    private $users;
    private $messages;
    private $emailer;
    private $certs;

    public function __construct(UserRepositoryInterface $users, MessagesRepositoryInterface $messages, Notifier $emailer, CertificationRepositoryInterface $certs)
    {
        $this->users = $users;
        $this->messages = $messages;
        $this->emailer = $emailer;
        $this->certs = $certs;
    }

    //handles an ajax request
    public function requestExam($cid, $eid)
    {
        if($this->certs->requestExam($cid, $eid))
        {
            return json_encode(
                ['success' => true,
                 'message' => 'Your exam has been successfully requested!']
            );
        }

        else { return json_encode(
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
        if($this->users->suspendUser($id))
        {
            return json_encode([
                'success' => true,
                'message' => 'User suspended'
            ]);
        }
        else
        {
            return json_encode([
                'success' => false,
                'message' => 'Error suspending user'
            ]);
        }
    }

    public function terminateUser($id)
    {
        if($this->users->terminateUser($id))
        {
            return json_encode([
                'success' => true,
                'message' => 'User terminated'
            ]);
        }
        else
        {
            return json_encode([
               'success' => false,
                'message' => 'Error terminating user'
            ]);
        }
    }
    public function activateUser($id)
    {
        if($this->users->activateUser($id))
        {
            return json_encode([
                'success' => true,
                'message' => 'User activated'
            ]);
        }
        else
        {
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
        }
        catch(InvalidArgumentException $e)
        {
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
        if($tr->delete())
        {
            return Redirect::home()->with('flash_success', 'Training session cancelled');
        }
        else
        {
            return Redirect::back()->with('flash_error', 'Unable to cancel session');
        }
    }

    public function acceptTrainingRequest($tsid)
    {
        if(\TrainingRequest::accept($tsid, \Sentry::getUser()->cid)) {
            return json_encode([
                'success' => true,
                'message' => 'Training session accepted'
            ]);
        }
        else
        {
            return json_encode([
                'success' => false,
                'message' => 'Error accepting training session'
            ]);
        }
    }

    public function dropTrainingRequest($tid)
    {
        if(\TrainingRequest::drop($tid, \Sentry::getUser()->cid)) {
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
            if($this->messages->markAllRead(\Sentry::getUser()->cid))
        {
            return json_encode([
                'success' => true,
                'message' => 'All messaged marked as read'
            ]);
        }
        else
        {
            return json_encode([
                'success' => false,
                'message' => 'Error marking messages read'
            ]);
        }
    }
}
