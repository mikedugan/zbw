<?php  namespace Zbw\Training\Commands; 

class CreateExamCommand
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
} 
