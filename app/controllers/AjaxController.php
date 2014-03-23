<?php 

use Zbw\Repositories\UserRepository;

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

    public function actionCompleted($aid)
    {
        $ar = new Zbw\Repositories\ActionRepository($aid);
        if($ar->resolve())
            return json_encode(['success' => true, 'message' => 'Notification marked completed!']);
        else return json_encode(['success' => false, 'message' => 'Notification could not be resolved!']);
    }

    public function sendStaffWelcome($cid)
    {
        $ur = new UserRepository($cid);
        $em = new \Zbw\Bostonjohn\Emailer($ur->getUser());
        $em->staffWelcome();
        return json_encode(['success' => true, 'message' => "Staff welcome email sent successfully!"]);
    }

    public function postReviewComment($eid)
    {
        $er = new \Zbw\Repositories\ExamsRepository();
    }

    public function suspendUser($id)
    {
        $ur = new UserRepository();
        if($ur->suspendUser($id))
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
        $ur = new UserRepository();
        if($ur->terminateUser($id))
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
}
