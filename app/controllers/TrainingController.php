<?php

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
        $ts = ControllerTraining::
            with(['student', 'location', 'staff', 'complexityType', 'weatherType', 'workloadType'])
            ->find($id);
        $data = [
            'title' => 'View Training Session',
            'tsession' => $ts,
            'student' => $ts->student,
            'staff' => $ts->staff,
            'location' => $ts->location
        ];
        return View::make('training.admin.session', $data);
    }

}
