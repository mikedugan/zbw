<?php  namespace Zbw\Training\Commands; 

class ProcessTrainingSessionCommand
{
    public $input;
    public $session_id;

    public function __construct($input, $tsid)
    {
        $this->input = $input;
        $this->session_id = $tsid;
    }
} 
