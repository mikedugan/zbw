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
        $data = [
          'exam' => $this->exams->get($eid)
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

    public function addQuestion()
    {
        if(! $this->questions->create(\Input::all())) {
            return Redirect::back()->with('flash_error', $this->questions->getErrors());
        }
        else {
            return Redirect::back()->with('flash_success', 'Question added successfully');
        }
    }
}
