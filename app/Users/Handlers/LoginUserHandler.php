<?php  namespace Zbw\Users\Handlers;

use Zbw\Core\BaseCommandResponse;
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
        $response = new BaseCommandResponse();
        $errors = $this->auth->oauthLogin($command->token, $command->verifier);
        if(! empty($errors)) {
            $response->setFlashData(['flash_error' => array_flatten($errors)]);
        } else {
            $response->setFlashData(['flash_success' => "You have been successfully logged in"]);
        }

        return $response;
    }
} 
