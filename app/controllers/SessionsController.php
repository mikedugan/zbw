<?php

use Illuminate\Session\Store;
use Zbw\Users\Auth\AuthService;

use Zbw\Users\Commands\LoginUserCommand;

class SessionsController extends BaseController
{
    private $auth;

    public function __construct(AuthService $auth, Store $session)
    {
        parent::__construct($session);
        $this->auth = $auth;
    }

    /**
     * @deprecated
     */
    public function getLogin()
    {
        return View::make('users.login');
    }

    public function oauthLogin()
    {
        if(\Input::has(['oauth_token', 'oauth_verifier'])) {
            $oauth_token = $this->input['oauth_token'];
            $oauth_verifier = $this->input['oauth_verifier'];
            $response = $this->execute(LoginUserCommand::class, ['token' => $oauth_token, 'verifier' => $oauth_verifier]);
            $this->setFlash($response->getFlashData());
            return $this->redirectIntended();
        } else {
            $this->auth->getTokenAndRedirect();
        }
    }

    public function postLogin()
    {
        $username = Input::get('username');
        $password = Input::get('password');
        $remember = Input::get('remember');
        if (strlen($username) == 2) {
            $user = User::where('initials', '=', $username)->firstOrFail();
        } else {
            if (strlen($username) > 5 && strlen($username) < 9) {
                $user = User::where('cid', '=', $username)->firstOrFail();
            } else {
                $user = User::where('username', '=', $username)->firstOrFail();
            }
        }

        if ( ! $user->activated) {
            return Redirect::back()->with(
              'flash_error',
              'Your account is not active. Please email <a
                   href="mailto:staff@bostonartcc.net">admin</a>'
            );
        }

        if (\Sentry::authenticate(['cid' => $user->cid, 'password' => $password], $remember)) {
            smfapi_login(\Sentry::getUser()->username);
            return Redirect::intended('/')->with(
              'flash_success',
              'You have been successfully logged in.'
            );
        }
        return Redirect::back()->with(
          'flash_error',
          'Invalid login credentials!'
        );
    }

    public function getLogout()
    {
        \Sentry::logout();
        return Redirect::home()->with(
          'flash_success',
          'You have been successfully logged out'
        );
    }

} 
