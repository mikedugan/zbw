<?php

use Illuminate\Session\Store;
use Zbw\Cms\Contracts\CommentsRepositoryInterface;
use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Training\Contracts\QuestionsRepositoryInterface;

use Zbw\Training\Commands\GetExamReviewCommand;
use Zbw\Training\Commands\CreateExamCommand;
use Zbw\Training\Exceptions\RecentExamException;

class ExamsController extends BaseController
{
    private $questions;
    private $comments;
    private $exams;

    public function __construct(CommentsRepositoryInterface $comments, ExamsRepositoryInterface $exams, QuestionsRepositoryInterface $questions, Store $session)
    {
        $this->comments = $comments;
        $this->exams = $exams;
        $this->questions = $questions;
        $this->session = $session;
        parent::__construct($session);
    }

    public function getIndex()
    {
        if(\Input::has('initials') || \Input::has('reviewed') || \Input::has('before') || \Input::has('after')) {
            $this->setData('exams', $this->exams->indexFiltered(\Input::all()));
            $this->setData('paginate', false);
        }
        else {
            $this->setData('exams', $this->exams->indexPaginated(10));
            $this->setData('paginate', true);
        }

        $this->view('training.exams.all');
    }

    public function getStaffReview($eid)
    {
        $exam = $this->exams->get($eid);
        $review_content = $this->execute(GetExamReviewCommand::class, ['exam' => $exam]);

        $this->setData('exam', $exam);
        $this->setData('comments', $exam->allComments());
        $this->setData('review_content', $review_content);
        $this->view('staff.exams.review');
    }

    public function getReview()
    {
        $exam = $this->exams->lastExam($this->current_user->cid);
        $review_content = $this->execute(GetExamReviewCommand::class, ['exam' => $exam]);

        $this->setData('exam', $exam);
        $this->setData('comments', $exam->allComments());
        $this->setData('review_content', $review_content);
        if ( ! $exam) {
            $this->setFlash(['flash_info' => 'No exams found']);
            $this->redirectBack();
        }
        $this->view('training.exams.review');
    }

    public function getIntro($eid)
    {
        $this->view('training.exams.intro');
    }

    public function getTake($eid)
    {
        $this->setData('exam', $this->exams->get($eid));
        $this->view('training.exams.take');
    }

    public function getQuestions()
    {
        if(\Input::has('exam')) {
            $this->setData('questions', $this->questions->indexFiltered(\Input::all()));
            $this->setData('paginate', false);
        }
        else {
              $this->setData('questions', $this->questions->indexPaginated(10));
              $this->setData('paginate', true);
        }
        $this->view('staff.exams.view-questions');
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
        $this->setData('question', $this->questions->get($id));
        $this->view('staff.exams.edit');
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
        try {
            $response = $this->execute(CreateExamCommand::class, ['user' => $this->current_user]);
        } catch (Exception $e) {
            $this->setFlash(['flash_error' => $e]);
            return $this->redirectBack();
        }

        $this->setData('questions', $response->getData()['questions']);
        $this->setData('exam', $response->getData()['exam']);

        $this->view('training.exams.take');
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
