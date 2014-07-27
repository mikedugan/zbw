<?php

use Zbw\Cms\FeedbackRepository;
use Zbw\Users\Contracts\UserRepositoryInterface;

class FeedbackController extends BaseController
{
    private $feedbacks;
    private $users;

    public function __construct(FeedbackRepository $feedbacks, UserRepositoryInterface $users)
    {
        $this->feedbacks = $feedbacks;
        $this->users = $users;
    }

    public function getFeedback()
    {
        $data = [
          'controllers' => $this->users->activeList()
        ];

        return View::make('zbw.feedback', $data);
    }

    public function postFeedback()
    {
        if($this->feedbacks->create(\Input::all())) {
            return Redirect::home()->with('flash_success', 'Feedback sent successfully!');
        }
        else {
            return Redirect::back()->with('flash_error', 'Error sending feedback');
        }
    }

    public function viewFeedback()
    {
        $feedback = $this->feedbacks->all();
        $data = [
            'feedbacks' => $feedback
        ];
        return View::make('staff.feedback', $data);
    }
}
