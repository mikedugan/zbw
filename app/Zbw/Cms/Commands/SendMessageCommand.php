<?php  namespace Zbw\Cms\Commands; 

class SendMessageCommand
{
    public $input;

    public function __construct($input)
    {
        $this->input = $input;
    }
} 
