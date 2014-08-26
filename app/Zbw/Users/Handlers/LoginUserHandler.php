<?php  namespace Zbw\Users\Handlers;

use Zbw\Users\Auth\AuthService;
use Zbw\Users\Commands\LoginUserCommand;

class LoginUserHandler
{
    private $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }
    public function handle(LoginUserCommand $command)
    {
        $this->auth->oauthLogin($command->token, $command->verifier);

    }
} 
