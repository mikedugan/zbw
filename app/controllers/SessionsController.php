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

    public function postLogin()
    {
        $sso = new \Zbw\Bostonjohn\Sso();
        $return = \Config::get('zbw.sso.return');
        //vatsim redirected user
        if(\Input::has('return')) {
            //does the session have data saved?
            $token = \AuthToken::where('key', \Input::get('oauth_token'))->get();
            if(count($token) > 0) {

                if(!\Input::has('oauth_verifier')) {
                    return Redirect::home()->with('flash_error', 'No verification code!');
                }

                $user = $sso->checkLogin($token->key, $token->secret, \Input::get('oauth_verifier'));
                if($user) {
                    $token->delete();
                    dd($user);
                    return Redirect::intended('/')->with('flash_success', 'You have been logged in successfully');
                }
                else {
                    ZbwLog::error($sso->error());
                    return Redirect::home()->with('flash_error', $sso->error());
                }
            }
        }

        $token = $sso->requestToken($return, false, false);
        if($token) {
            $token = new \AuthToken();
            $token->key = $token->token->oauth_token;
            $token->secret = $token->token->oauth_token_secret;
            $token->save();
            $sso->sendToVatsim();
        }
        else {
            ZbwLog::error($sso->error());
            return Redirect::home()->with('flash_error', $sso->error());
        }


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

        if (Auth::attempt(
          array('cid' => $user->cid, 'password' => $password),
          true
        )
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
        Auth::logout();
        return Redirect::home()->with(
          'flash_success',
          'You have been successfully logged out'
        );
    }

} 
