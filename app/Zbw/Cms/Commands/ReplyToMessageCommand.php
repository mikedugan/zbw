<?php  namespace Zbw\Cms\Commands; 

class ReplyToMessageCommand
{
    public $input;
    public $message_id;

    public function __construct($input, $message_id)
    {

        $this->input = $input;
        $this->message_id = $message_id;
    }
} 
