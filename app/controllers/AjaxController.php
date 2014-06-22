<?php 

use Zbw\Users\UserRepository;
use Zbw\Cms\MessagesRepository;
use Zbw\Bostonjohn\Emailer;
use Zbw\Training\CertificationRepository;

class AjaxController extends BaseController
{
    private $users;
    private $messages;
    private $emailer;
    private $certs;

    public function __construct(UserRepository $users, MessagesRepository $messages, Emailer $emailer, CertificationRepository $certs)
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
        $em = new Emailer(\Auth::user()->cid);
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
        if(\TrainingRequest::create(\Input::all())) {
            return json_encode([
                'success' => true,
                'message' => 'Training request added successfully for ' . $i['start']
            ]);
        }
        else
        {
            return json_encode([
               'success' => false,
                'messaage' => 'Error sending training request!'
            ]);
        }
    }

    public function cancelTrainingRequest($tsid)
    {
        $tr = TrainingRequest::find($tsid);
        if($tr->delete())
        {
            return json_encode([
                'success' => true,
                'message' => 'Training request cancelled'
            ]);
        }
        else
        {
            return json_encode([
                'success' => false,
                'message' => 'Error cancelling training request'
            ]);
        }
    }

    public function acceptTrainingRequest($tsid)
    {
        if(\TrainingRequest::accept($tsid, Auth::user()->cid)) {
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

    public function markInboxRead()
    {
            if($this->messages->markAllRead(Auth::user()->cid))
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
