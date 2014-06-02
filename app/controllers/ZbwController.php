<?php

use Zbw\Cms\NewsRepository;

class ZbwController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'vZBW ARTCC',
			'me' => Auth::user(),
			'news' => NewsRepository::front(5),
      'metars' => \Metar::frontPage(),
      'atcs' => \ZbwStaffing::frontPage(),
      'flights' => \ZbwFlight::frontPage()
		];
		return View::make('zbw', $data);

	}

	public function getControllerIndex()
	{
		$data = [
			'title' => 'vZBW Controller Home'
		];
		return View::make('zbw.controllers', $data);
	}

	public function getPilotIndex()
	{
		$data = [
			'title' => 'vZBW Pilot Home'
		];
		return View::make('zbw.pilots', $data);
	}

}
