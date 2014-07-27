<?php namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;
use Zbw\Cms\Contracts\FeedbackRepositoryInterface;

class FeedbackRepository extends EloquentRepository implements FeedbackRepositoryInterface
{

    protected $model = '\PilotFeedback';

    public function update($input)
    {
    }

    public function create($input)
    {
        $feedback = new \PilotFeedback;
        $feedback->controller = $input['controller'];
        $feedback->rating = $input['rating'];
        $feedback->ip = $this->getIp();
        $feedback->comments = $input['message'];
        $feedback->email = $input['email'];
        $feedback->name = $input['fname'] . ' ' . $input['lname'];

        return $this->checkAndSave($feedback);
    }

    public function getIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function byRecent()
    {
        return $this->make()->orderBy('created_at', 'DESC')->get();
    }
}
