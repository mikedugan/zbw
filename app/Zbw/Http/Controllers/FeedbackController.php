<?php

namespace Zbw\Http\Controllers;

use Illuminate\Session\Store;
use View;
use Zbw\Cms\FeedbackRepository;
use Zbw\Http\Controllers\BaseController;
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
        if ($this->feedbacks->create(\Input::all())) {
            return \Redirect::home()->with('flash_success', 'Feedback sent successfully!');
        } else {
            return \Redirect::back()->with('flash_error', 'Error sending feedback');
        }
    }

    public function viewFeedback()
    {
        $feedback = $this->feedbacks->byRecent();
        $this->setData('feedbacks', $feedback);
        return $this->view('staff.feedback');
    }

    public function deleteFeedback($id)
    {
        $feedback = $this->feedbacks->get($id);
        if ($feedback->delete()) {
            $this->setFlash(['flash_success' => 'Feedback deleted successfully']);
        } else {
            $this->setFlash(['flash_error' => 'There was an error deleting the feedback']);
        }

        return $this->redirectBack();
    }
}
