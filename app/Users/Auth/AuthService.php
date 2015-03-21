<?php  namespace Zbw\Users\Auth;

use Cartalyst\Sentry\Users\UserNotFoundException;
use Zbw\Users\Contracts\UserRepositoryInterface;

class AuthService
{
    private $sso;
    private $users;
    private $token;
    private $errors;

    function __construct(Sso $sso, UserRepositoryInterface $users)
    {
        $this->sso = $sso;
        $this->users = $users;
        $this->errors = [];
    }

    public function login()
    {

    }

    public function getTokenAndRedirect()
    {
        $ssotoken = $this->sso->requestToken(\Config::get('zbw.sso.return'), false, false);
        if ($ssotoken) {
            $token = new \AuthToken();
            $token->key = $ssotoken->token->oauth_token;
            $token->secret = $ssotoken->token->oauth_token_secret;
            $token->save();
            $this->sso->sendToVatsim();
        } else {
            return $this->sso->error();
        }
    }

    public function oauthLogin($oauth_token, $oauth_verifier)
    {
        $user = $this->getOauthUser($oauth_token, $oauth_verifier);

        $this->loginOauthUser($user);

        return $this->errors;
    }

    private function getOauthUser($oauth_token, $oauth_verifier)
    {
        //retrieve the token
        $this->token = \AuthToken::where('key', $oauth_token)->first();
        //get the user's data from VATSIM
        $oauth_user = $this->sso->checkLogin($this->token->key, $this->token->secret, $oauth_verifier);
        return $oauth_user;
    }

    /**
     * @param $oauth_user
     * @return bool
     */
    private function loginOauthUser($oauth_user)
    {
        //delete the token for security
        $this->token->delete();
        //fetch the user
        try {
            $loggedinuser = \Sentry::findUserById($oauth_user->user->id);
        } catch (UserNotFoundException $e) {
            return;
        }
        //make sure they are active
        $userStatus = $this->users->checkUser($loggedinuser);
        if ($userStatus) {
            //if not, push the errors
            array_push($this->errors, $userStatus);
            return;
        }
        //login the user to the site
        \Sentry::login($loggedinuser, true);
        //login the user to the forum
        if(function_exists('smfapi_login')) {
            smfapi_login($loggedinuser->username);
        }
        //update the user
        $this->users->authUpdate($oauth_user);
    }
}
