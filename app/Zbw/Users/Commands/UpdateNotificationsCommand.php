<?php  namespace Zbw\Users\Commands; 

class UpdateNotificationsCommand
{
    private $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function getInput()
    {
        return $this->input;
    }
} 
