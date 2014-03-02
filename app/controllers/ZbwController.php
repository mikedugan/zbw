<?php

class ZbwController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'vZBW ARTCC'
		];
		return View::make('zbw', $data);

	}

	public function getControllerIndex()
	{
		$data = [
			'title' => 'vZBW Controller Home'
		];
		return View::make('controllers/index', $data);
	}

	public function getPilotIndex()
	{
		return "pilot index";
	}

}
