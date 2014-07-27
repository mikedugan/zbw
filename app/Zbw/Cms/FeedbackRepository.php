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
        $feedback->feedback = $input['message'];
        $feedback->name = $input['fname'] . ' ' . $input['lname'];

        return $this->checkAndSave($feedback);
    }

    public function getIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}
