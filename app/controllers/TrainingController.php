<?php

use Zbw\Repositories\TrainingSessionRepository;

class TrainingController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'Training Center'
		];
		return View::make('training.index', $data);
	}

    public function showAdmin($id)
    {
        $ts = TrainingSessionRepository::findWithRelations($id);
        $data = [
            'title' => 'View Training Session',
            'tsession' => $ts,
            'student' => $ts->student,
            'staff' => $ts->staff,
            'location' => $ts->location
        ];
        return View::make('staff.training.session', $data);
    }

    public function getRequest()
    {
        $data = [
            'title' => 'Request Training Session',
            'available' => ExamsRepository::availableExams(Auth::user()->cid)
        ];
        return View::make('training.request', $data);
    }

    public function showRequest($tid)
    {
        $request = \TrainingRequest::with(['student', 'certType', 'staff'])->find($tid);
        $ur = new \Zbw\Repositories\UserRepository($request->student->cid);
        $data = [
            'title' => 'View Training Request',
            'student' => $ur->getUser(),
            'request' => $request
        ];
        return View::make('training.show-request', $data);
    }

}
