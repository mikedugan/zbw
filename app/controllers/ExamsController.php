<?php

use Zbw\Cms\CommentsRepositoryInterface;
use Zbw\Training\QuestionsRepository;
use Zbw\Training\ExamsRepositoryInterface;

class ExamsController extends BaseController
{
    private $questions;
    private $comments;
    private $exams;

    public function __construct(QuestionsRepository $questions, CommentsRepositoryInterface $comments, ExamsRepositoryInterface $exams)
    {
        $this->questions = $questions;
        $this->comments = $comments;
        $this->exams = $exams;
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
        $data = [
          'title'     => 'vZBW Question Bank',
          'questions' => $this->questions->all()
        ];
        return View::make('staff.exams.view-questions', $data);
    }

    public function postComment($eid)
    {
        $post = \Input::all();
        if ($this->comments->create(
          [
            'content'      => $post['content'],
            'parent_id'    => $eid,
            'comment_type' => 5
          ]
        )
        ) {
            return Redirect::back()->with(
              'flash_success',
              'Comment added successfully'
            );
        } else {
            return Redirect::back()->with(
              'flash_error',
              'Error adding comment'
            );
        }
    }

    public function addQuestion()
    {
        if ($this->questions->create(Input::all())) {
            $log = new \Zbw\Bostonjohn\ZbwLog();
            $log->addLog(Auth::user()->initials . 'added an exam question', '');
            return Redirect::back()->with(
              'flash_success',
              'Exam question added'
            );
        } else {
            $log = new \Zbw\Bostonjohn\ZbwLog();
            $log->addError('There was an error while adding an exam question');
            return Redirect::back()->with(
              'flash_error',
              'Error adding exam question'
            );
        }

    }
}