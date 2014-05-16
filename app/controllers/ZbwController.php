<?php

class ZbwController extends BaseController {

    public function __construct() {
        $this->news = new \Zbw\Repositories\NewsRepository();
    }
	public function getIndex()
	{
		$data = [
			'title' => 'vZBW ARTCC',
			'me' => Auth::user(),
			'news' => $this->news->front(5)
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
