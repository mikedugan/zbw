<?php 

use Zbw\Users\UserRepository;
use Zbw\Messages\MessagesRepository;
use Zbw\Bostonjohn\Emailer;

class AjaxController extends BaseController
{
    //handles an ajax request
    public function requestExam($cid, $eid)
    {
        $cr = new \Zbw\Repositories\CertificationRepository($eid);
        if($cr->requestExam($cid))
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
        $ur = new UserRepository();
        if(UserRepository::suspendUser($id))
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
        if(UserRepository::terminateUser($id))
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
        if(UserRepository::activateUser($id))
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
        $i = Input::all();
        $tr = new \TrainingRequest();
        $tr->cid = $i['user'];
        $tr->start = $i['start'];
        $tr->end = $i['end'];
        $tr->cert = $i['cert'];
        if($tr->save()) {
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

    public function cancelTrainingRequest($tid)
    {
        $tr = \TrainingRequest::find($tid);
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

    public function acceptTrainingRequest($tid)
    {
        $tr = \TrainingRequest::find($tid);
        $tr->sid = $tr->sid == null ? Auth::user()->cid : $tr->sid;
        if($tr->save() && $tr->sid == Auth::user()->cid)
        {
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
        if(MessagesRepository::markAllRead(Auth::user()->cid))
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
