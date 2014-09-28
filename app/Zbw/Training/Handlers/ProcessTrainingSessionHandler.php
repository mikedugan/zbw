<?php  namespace Zbw\Training\Handlers; 

use Zbw\Training\Commands\ProcessTrainingSessionCommand;
use Zbw\Training\TrainingRequestRepository;
use Zbw\Training\TrainingSessionGrader;

class ProcessTrainingSessionHandler
{
    private $requests;

    public function __construct(TrainingRequestRepository $requests)
    {
        $this->requests = $requests;
    }

    public function handle(ProcessTrainingSessionCommand $command)
    {
        $report = (new TrainingSessionGrader($command->input))->fileReport();
        if($report instanceof \TrainingSession) {
            $this->requests->complete($command->session_id, $report->id);
            return true;
        } else {
            return false;
        }
    }
} 
