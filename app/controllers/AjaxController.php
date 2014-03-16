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
}
