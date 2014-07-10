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

    }
}
