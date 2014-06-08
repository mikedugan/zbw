<?php  namespace Zbw\Users; 

use Zbw\Bostonjohn\Sso;

class SessionManager {

    private $auth;

    public function __construct()
    {
        $this->auth = new Sso();
    }

    public function authenticateUser()
    {}

} 
