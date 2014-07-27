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
        $feedback = \PilotFeedback::create([
            'controller' => $input['controller'],
            'rating' => $input['rating'],
            'ip' => $this->getIp(),
            'feedback' => $input['message'],
            'name' => $input['fname'] . ' ' . $input['lname']
        ]);
        return $feedback->save();
    }

    public function getIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}
