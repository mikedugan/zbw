<?php  namespace Zbw\Training\Commands; 

class AdoptUserCommand
{
    public $meeting;
    public $message;
    public $subject;
    public $cid;
    public $sid;

    public function __construct($meeting, $message, $subject, $cid, $sid)
    {
        $this->meeting = $meeting;
        $this->message = $message;
        $this->subject = $subject;
        $this->cid = $cid;
        $this->sid = $sid;
    }
} 
