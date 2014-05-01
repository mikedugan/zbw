<?php
use Zbw\Repositories\MessagesRepository;

class ControllersController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'vZBW Controller Home'
		];
		return View::make('zbw.controllers');
	}

	/**
	 * this route specifically handles when the logged in user navigates to their own profile
	 */
	public function getMe()
	{
		$data = [
			'messages' => MessagesRepository::to(Auth::user()->cid),
		];
		return View::make('users.me', $data);
	}

	public function view($cid)
	{

	}

}
