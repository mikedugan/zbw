<?php

use Zbw\Training\TrainingSessionRepository;
use Zbw\Training\ExamsRepository;

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
        $ts = TrainingSessionRepository::find($id, "all");
        $data = [
            'tsession' => $ts,
            'student' => $ts->student,
            'staff' => $ts->staff,
            'location' => $ts->facility
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

    public function getReview()
    {
        $exam = ExamsRepository::lastExam(Auth::user()->cid);
        $data = [
            'exam' => $exam
        ];
        if( ! $exam) { return Redirect::back()->with('flash_info', 'No exams found'); }
        return View::make('training.exams.review', $data);
    }

}
