<?php

use Zbw\Training\QuestionsRepository;
use Zbw\Cms\CommentsRepository;

class ControllerExamsController extends BaseController {

	public function getStaffReview($eid)
    {
        $data = [
            'exam' => \ControllerExam::with(['student', 'comments'])->find($eid)
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
            'exam' => $this->er->get($eid)
        ];

        return View::make('training.exams.take', $data);
    }

    public function getQuestions()
    {
        $data = [
            'title' => 'vZBW Question Bank',
            'questions' => QuestionsRepository::all()
        ];
        return View::make('staff.exams.view-questions', $data);
    }

    public function postComment($eid)
    {
        $post = \Input::all();
        if(CommentsRepository::add([
            'content' => $post['content'],
            'parent_id' => $eid,
            'comment_type' => 5
        ]))
        {
            return Redirect::back()->with('flash_success', 'Comment added successfully');
        } else {
            return Redirect::back()->with('flash_error', 'Error adding comment');
        }
    }

    public function addQuestion()
    {
        if(QuestionsRepository::add(Input::all()))
        {
            $log = new \Zbw\Bostonjohn\ZbwLog();
            $log->addLog(Auth::user()->initials . 'added an exam question', '');
            return Redirect::back()->with('flash_success', 'Exam question added');
        }
        else
        {
            $log = new \Zbw\Bostonjohn\ZbwLog();
            $log->addError('There was an error while adding an exam question');
            return Redirect::back()->with('flash_error', 'Error adding exam question');
        }

    }
}
