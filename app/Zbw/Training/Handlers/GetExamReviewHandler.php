<?php  namespace Zbw\Training\Handlers; 

use Zbw\Training\Commands\GetExamReviewCommand;

class GetExamReviewHandler
{
    public function handle(GetExamReviewCommand $command)
    {
        $decoded = json_decode($command->exam->exam);
        $wrongset = property_exists($decoded, 'wrong') ? $decoded->wrong : null;
        if (count($wrongset) > 0) {
            foreach ($wrongset as $q) {
                $question = \ExamQuestion::find($q->question);
                $wrong[] = [
                  'question' => $question,
                  'answer'   => $question->{'answer_' . $q->answer}
                ];
            }
        } else {
            $wrong = 'Wow, 100%! Great job!';
        }

        return $wrong;
    }
} 
