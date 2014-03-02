<?php

class ZbwController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'vZBW ARTCC'
		];
		return View::make('zbw', $data);

	}

	public function getPilotIndex()
	{
		return "pilot index";
	}

}
