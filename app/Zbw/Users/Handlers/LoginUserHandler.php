<?php  namespace Zbw\Users\Handlers; 

use Zbw\Users\Auth\Sso;
use Zbw\Users\Commands\LoginUserCommand;

class LoginUserHandler
{
    public function handle(LoginUserCommand $command)
    {
        dd($command);

        $sso = new Sso();

        //vatsim redirected user
        if(isset($command->input['oauth_token'])) {
            //does the session have data saved?
            $status = \AuthToken::checkLogin(\Input::all(), $sso);
            if (is_string($status))
                throw new \Exception($status);
            else
                return Redirect::intended('/')->with(
                  'flash_success',
                  'You have been logged in successfully'
                );
        } else if ($status = \AuthToken::setupToken($sso)) {
            throw new \ErrorException($status);
        }
    }
} 
