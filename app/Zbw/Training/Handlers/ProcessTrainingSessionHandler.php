<?php  namespace Zbw\Training\Handlers; 

use Zbw\Training\Commands\ProcessTrainingSessionCommand;
use Zbw\Training\TrainingSessionGrader;

class ProcessTrainingSessionHandler
{
    public function handle(ProcessTrainingSessionCommand $command)
    {
        $report = (new TrainingSessionGrader($command->input))->fileReport();
        if($report instanceof \TrainingSession) {
            \TrainingRequest::complete($command->session_id, $report->id);
            return true;
        } else {
            return false;
        }
    }
} 
