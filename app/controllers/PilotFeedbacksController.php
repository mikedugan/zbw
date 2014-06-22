<?php

use Zbw\Cms\FeedbackRepository;

class PilotFeedbacksController extends BaseController
{
    private $feedbacks;

    public function __construct(FeedbackRepository $feedbacks)
    {
        $this->feedbacks = $feedbacks;
    }

    public function getIndex()
    {
        $data = [
          'feedback' => $this->feedbacks->all(),
          'title'    => 'Pilot Feedback'
        ];

        return View::make('feedback.index', $data);
    }

}
