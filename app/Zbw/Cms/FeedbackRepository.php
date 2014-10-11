<?php namespace Zbw\Cms;

use Zbw\Core\EloquentRepository;
use Zbw\Cms\Contracts\FeedbackRepositoryInterface;

/**
 * @package Zbw\Cms
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class FeedbackRepository extends EloquentRepository implements FeedbackRepositoryInterface
{

    /**
     * @var string
     */
    protected $model = '\PilotFeedback';

    /**
     * @param $input
     * @return void
     */
    public function update($input)
    {
    }

    /**
     * @param $input
     * @return bool
     */
    public function create($input)
    {
        $feedback = new \PilotFeedback;
        $feedback->controller = $input['controller'];
        $feedback->rating = $input['rating'];
        $feedback->ip = $this->getIp();
        $feedback->comments = $input['message'];
        $feedback->email = $input['email'];
        $feedback->response = isset($input['response']) ? 1 : 0;
        $feedback->name = $input['fname'] . ' ' . $input['lname'];

        return $this->checkAndSave($feedback);
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return mixed
     */
    public function byRecent()
    {
        return $this->make()->orderBy('created_at', 'DESC')->get();
    }
}
