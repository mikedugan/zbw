<?php  namespace Zbw\Training\Handlers;

use Zbw\Base\BaseCommandResponse;
use Zbw\Training\Commands\CreateExamCommand;
use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Training\Contracts\QuestionsRepositoryInterface;
use Zbw\Training\Exceptions\ExamCreatorException;
use Zbw\Training\Exceptions\RecentExamException;

class CreateExamHandler
{
    private $questions;
    private $exams;

    public function __construct(QuestionsRepositoryInterface $questions, ExamsRepositoryInterface $exams)
    {
        $this->questions = $questions;
        $this->exams = $exams;
    }

    public function handle(CreateExamCommand $command)
    {
        $response = new BaseCommandResponse();
        $recent = $this->exams->lastDay($command->user->cid);
        if(count($recent) > 0) {
            throw new RecentExamException;
        }

        $next_cert = \CertType::find($command->user->cert + 1);
        $count = \Config::get('zbw.exam_length.'.$next_cert->value);
        $exam = [
          'cid' => $command->user->cid,
          'cert_type_id' => $next_cert->id,
          'assigned_on' => \Carbon::now(),
          'total_questions' => $count
        ];

        if(! $exam = $this->exams->create($exam)) {
            throw new ExamCreatorException($this->exams->getErrors());
        } else {
            $questions = $this->questions->exam($command->user->cert + 1, $count);
            $response->setData(['questions' => $questions, 'exam' => $exam]);
        }

        return $response;
    }
} 
