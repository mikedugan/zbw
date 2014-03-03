<?php

class ZbwController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'vZBW ARTCC',
			'me' => Auth::user()
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
		$data = [
			'title' => 'vZBW Pilot Home'
		];
		return View::make('pilots/index', $data);
	}

}
