<?php
use Zbw\Repositories\MessagesRepository;
use Zbw\Repositories\UserRepository;

class ControllersController extends BaseController {

	public function getIndex()
	{
		$data = [
		];
		return View::make('zbw.controllers');
	}

    public function getController($id)
    {
        $data = [
            'controller' => UserRepository::find($id, ['certification'])
        ];

        return View::make('users.show', $data);

    }

	/**
	 * this route specifically handles when the logged in user navigates to their own profile
	 */
	public function getMe()
	{
		$data = [
			'messages' => MessagesRepository::to(Auth::user()->cid),
		];
		return View::make('users.me.index', $data);
	}

	public function getSettings()
	{
		$data = [
		];
		return View::make('users.me.settings', $data);
	}

	public function view($cid)
	{

	}

}
