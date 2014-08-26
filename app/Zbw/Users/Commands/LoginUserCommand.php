<?php  namespace Zbw\Users\Commands; 

class LoginUserCommand
{
    public $token;
    public $verifier;

    public function __construct($token, $verifier)
    {
        $this->token = $token;
        $this->verifier = $verifier;
    }
} 
