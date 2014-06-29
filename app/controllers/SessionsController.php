<?php

use Zbw\Bostonjohn\ZbwLog;

class SessionsController extends BaseController
{

    /**
     * @deprecated
     */
    public function getLogin()
    {
        $data = [
          'title' => 'vZBW Login'
        ];
        return View::make('users.login', $data);
    }

    public function oauthLogin()
    {
        $sso = new \Zbw\Bostonjohn\Sso();
        $return = \Config::get('zbw.sso.return');
        //vatsim redirected user
        if (\Input::has('oauth_token')) {
            //does the session have data saved?
            $status = \AuthToken::checkLogin(\Input::all(), $sso);
            if (is_string($status))
                return Redirect::home()->with('flash_error', $status);
            else
                return Redirect::intended('/')->with(
                  'flash_success',
                  'You have been logged in successfully'
                );
        } else if ($status = \AuthToken::setupToken($sso)) {
            return Redirect::home()->with('flash_error', $status);
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

        if ( ! $user->is_active) {
            return Redirect::back()->with(
              'flash_error',
              'Your account is not active. Please email <a
                   href="mailto:staff@bostonartcc.net">admin</a>'
            );
        }

        if (\Sentry::authenticate(['cid' => $user->cid, 'password' => $password], $remember)
        ) {
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
