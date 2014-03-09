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
        $ts = ControllerTraining::find($id);
        $data = [
            'title' => 'View Training Session',
            'tsession' => $ts
        ];
        return View::make('training.admin.session', $data);
    }

}
