<?php

use Zbw\Cms\Contracts\CommentsRepositoryInterface;
use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Training\Contracts\QuestionsRepositoryInterface;

class ExamsController extends BaseController
{
    private $questions;
    private $comments;
    private $exams;

    public function __construct(CommentsRepositoryInterface $comments, ExamsRepositoryInterface $exams, QuestionsRepositoryInterface $questions)
    {
        $this->comments = $comments;
        $this->exams = $exams;
        $this->questions = $questions;
    }

    public function getIndex()
    {
        if(\Input::has('initials') || \Input::has('reviewed') || \Input::has('before') || \Input::has('after')) {
            $data = [
              'exams' => $this->exams->indexFiltered(\Input::all()),
              'paginate' => false
            ];
        }
        else {
            $data = [
                'exams' => $this->exams->indexPaginated(10),
                'paginate' => true
            ];
        }

        return View::make('training.exams.all', $data);
    }

    public function getStaffReview($eid)
    {
        $exam = $this->exams->get($eid);
        $wrong = [];
        $wrongset = json_decode($exam->exam)->wrong;
        foreach($wrongset as $q) {
            $question = \ExamQuestion::find($q->question);
            $wrong[] = [
              'question' => $question,
              'answer' => $question->{'answer_'.$q->answer}
            ];
        }
        $data = [
          'exam' => $exam,
          'wrong' => $wrong
        ];
        return View::make('staff.exams.review', $data);
    }

    public function getIntro($eid)
    {
        $data = [
          'title' => 'vZBW Exam Center'
        ];

        return View::make('training.exams.intro', $data);
    }

    public function getTake($eid)
    {
        $data = [
          'title' => 'Take Exam',
          'exam'  => $this->exams->get($eid)
        ];

        return View::make('training.exams.take', $data);
    }

    public function getQuestions()
    {
        if(\Input::has('exam')) {
            $data = [
                'questions' => $this->questions->indexFiltered(\Input::all()),
                'paginate' => false
            ];
        }
        else {
            $data = [
              'questions' => $this->questions->indexPaginated(10),
              'paginate' => true
            ];
        }
        return View::make('staff.exams.view-questions', $data);
    }

    public function postComment($eid)
    {
        $post = \Input::all();
        $post['comment_type'] = \MessageType::where('value', 'c_exam')->first()->id;
        if($this->comments->add($post)) {
            return Redirect::back()->with('flash_success','Comment added successfully');
        } else {
            return Redirect::back()->with('flash_error', $this->comments->getErrors());
        }
    }

    public function getEditQuestion($id)
    {
        $data = [
            'question' => $this->questions->get($id)
        ];

        return View::make('staff.exams.edit', $data);
    }

    public function postEditQuestion($id)
    {
        if(! $this->questions->update(\Input::all())) {
            return Redirect::back()->with('flash_error', $this->questions->getErrors());
        }
        else {
            return Redirect::back()->with('flash_success', 'Question updated successfully');
        }
    }

    public function addQuestion()
    {
        if(! $this->questions->create(\Input::all())) {
            return Redirect::back()->with('flash_error', $this->questions->getErrors());
        }
        else {
            return Redirect::back()->with('flash_success', 'Question added successfully');
        }
    }

    public function deleteQuestion($id)
    {
        if($this->questions->delete($id)) {
            return Redirect::route('staff/exams/questions')->with('flash_success', 'Question deleted');
        }
        else return Redirect::back()->with('flash_error', 'Error deleting question');
    }

    public function takeExam()
    {
        $user = \Sentry::getUser();
        $next_cert = \CertType::find($user->cert + 1);
        $count = \Config::get('zbw.exam_length.'.$next_cert->value);
        $exam = [
            'cid' => $user->cid,
            'cert_type_id' => $next_cert->id,
            'assigned_on' => \Carbon::now(),
            'total_questions' => $count
        ];

        $recent = $this->exams->lastDay($user->cid);
        if(count($recent) > 0) {
            return Redirect::route('training')->with('flash_error', 'You have taken an exam within the past 24 hours!');
        }

        if(! $exam = $this->exams->create($exam)) {
            return Redirect::back()->with('flash_error', $this->exams->getErrors());
        }

        $data = [
            'questions' => $this->questions->exam($user->cert + 1, $count),
            'exam' => $exam
        ];

        return View::make('training.exams.take', $data);
    }

    public function gradeExam()
    {
        $this->exams->grade(\Input::all());
        $exam = \Exam::find(\Input::get('examid'));
        $score = round($exam->correct / $exam->total_questions * 100, 2);
        if($exam->pass) {
            return Redirect::route('training')->with('flash_success', 'You passed your exam with a score of '.$score.'%. Click "Review Exams" to provide corrections and view with staff.');
        }
        else {
            return Redirect::route('training')->with('flash_error', 'You failed your exam with a score of '.$score.'%. Click "Review Exams" to provide corrections and view with staff. You
            may retake the exam in 7 days.');
        }
    }
}
