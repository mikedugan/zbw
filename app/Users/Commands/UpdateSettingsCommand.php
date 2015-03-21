<?php  namespace Zbw\Users\Commands; 

class UpdateSettingsCommand
{
    private $input;

    function __construct($input)
    {
        $this->input = $input;
    }

    public function getInput()
    {
        return $this->input;
    }
}
