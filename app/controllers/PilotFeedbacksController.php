<?php

class PilotFeedbacksController extends BaseController {

	public function getIndex()
	{
		$data = [
			'feedback' => PilotFeedback::all(),
			'title' => 'Pilot Feedback'
		];

		return View::make('feedback.index', $data);
	}

}
