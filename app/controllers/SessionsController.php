<?php
/**
 * Created by PhpStorm.
 * User: mdugan
 * Date: 3/2/14
 * Time: 3:12 PM
 */

class SessionsController extends BaseController {
	public function getLogin()
	{
		$data = [
			'title' => 'vZBW Login'
		];
		return View::make('controllers.login', $data);
	}

	public function postLogin()
	{
		$username = Input::get('username');
		$password = Input::get('password');
		$remember = Input::get('remember');
		if(strlen($username) == 2) {
			$user = User::where('initials', '=', $username)->firstOrFail();
		}

		else if(strlen($username) > 5 && strlen($username) < 9){
			$user = User::where('cid', '=', $username)->firstOrFail();
		}

		else {
			$user = User::where('username', '=', $username)->firstOrFail();
		}

		if(! $user->is_active)
		{
			return Redirect::back()->with('flash_error', 'Your account is not active. Please email <a
			href="mailto:staff@bostonartcc.net"');
		}

		if($remember == 'remember')
		{
			if(Auth::attempt(array('cid' => $user->cid, 'password' => $password), true))
			{
				return Redirect::intended('/')->with('flash_success', 'You have been successfully logged in.');
			}
			else
			{
				return Redirect::back()->with('flash_error', 'Invalid login credentials');
			}
		}
		else
		{
			if(Auth::attempt(array('cid' => $user->cid, 'password' => $password)))
			{
				return Redirect::intended('/')->with('flash_success', 'You were successfully logged in.');
			}
			else
			{
				return Redirect::back()->with('flash_error', 'Invalid login credentials');
			}
		}




	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::home()->with('flash_success', 'You have been successfully logged out');
	}

} 