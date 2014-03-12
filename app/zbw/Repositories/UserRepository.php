<?php  namespace Zbw\Repositories;

class UserRepository
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user ? $user : null;
    }

    public function all()
    {
        return \User::all();
    }
} 
