<?php

class ControllersController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'vZBW Controller Home'
		];
		return View::make('zbw.controllers');
	}

}
