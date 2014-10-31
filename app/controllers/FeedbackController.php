<?php

use Illuminate\Session\Store;
use Zbw\Cms\FeedbackRepository;
use Zbw\Users\Contracts\UserRepositoryInterface;

class FeedbackController extends BaseController
{
    private $feedbacks;
    private $users;

    public function __construct(FeedbackRepository $feedbacks, UserRepositoryInterface $users, Store $session)
    {
        $this->feedbacks = $feedbacks;
        $this->users = $users;
        parent::__construct($session);
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
        $feedback = $this->feedbacks->byRecent();
        $data = [
            'feedbacks' => $feedback
        ];
        return View::make('staff.feedback', $data);
    }

    public function deleteFeedback($id)
    {
        $feedback = $this->feedbacks->get($id);
        if($feedback->delete()) {
            return $this->redirectBack()->with('flash_success', 'Feedback deleted successfully');
        } else {
            return $this->redirectBack()->with('flash_error', 'There was an error deleting the feedback');
        }
    }
}
