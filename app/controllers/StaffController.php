<?php

class StaffController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'vZBW Staff Home'
		];
		return View::make('staff.index', $data);
	}

}
