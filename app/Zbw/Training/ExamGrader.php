<?php  namespace Zbw\Training; 

class ExamGrader {

    public function grade($exam)
    {
        $correct = 0;
        $wrong = 0;
        $results = [
            'questions' => [],
            'total_questions' => count($exam),
            'wrong ' => []
        ];

        $exam_id = $exam['examid'];
        unset($exam['examid']);

        foreach($exam as $question)
        {
            $id = $question['id'] + 1;
            $q = \ExamQuestion::find($id);
            $exam['questions'][] = $id;
            if($this->isCorrect($q->id, $question['answer'])) {
                $correct++;
            }
            else {
                $results['wrong'][] = [
                    'question' => $q->id,
                    'answer' => $question['answer'],
                    'correct' => $q->correct
                ];
                $wrong++;
            }
        }
        $this->saveExamResults($exam, $wrong, $correct, $exam_id);
        return [$correct, $wrong, $id]
    }

    private function saveExamResults($exam, $wrong, $correct, $id)
    {
        $e = \Exam::find($id);
        $e->exam = json_encode($exam);
        $e->questions = json_encode($exam['questions']);
        $e->correct = $correct;
        $e->wrong = $wrong;
        $e->completed_on = \Carbon::now();
        $total = $wrong + $correct;
        if(($correct / $total * 100) < 80) $e->pass = 0;
        else $e->pass = 1;
        return $e->save();
    }

    private function isCorrect($id, $answer)
    {
        $ianswer = 0;
        $q = \ExamQuestion::find($id);
        if($answer == 'a') { $ianswer = 1; }
        else if($answer == 'b') { $ianswer = 2; }
        else if($answer == 'c') { $ianswer = 3; }
        else if($answer == 'd') { $ianswer = 4; }
        else if($answer == 'e') { $ianswer = 5; }
        else if($answer == 'f') { $ianswer = 6; }
        if($ianswer == $q->correct) return true;
        else return false;
    }
} 
