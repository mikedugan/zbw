<?php  namespace Zbw\Cms;

use Zbw\Core\EloquentRepository;
use Zbw\Cms\Contracts\CommentsRepositoryInterface;

/**
 * @package Cms
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.b
 */
class CommentsRepository extends EloquentRepository implements CommentsRepositoryInterface
{
    /**
     *
     */
    public $model = '\Comment';

    /**
     *  creates a new Comment
     * @param $input
     * @return bool
     */
    public function add($input)
    {
        $comment = new \Comment;
        $comment->content= $input['content'];
        $comment->parent_id = $input['parent_id'];
        $comment->comment_type = $input['comment_type'];
        $comment->author = \Sentry::getUser()->cid;
        $result = $this->checkAndSave($comment);
        if($comment->comment_type === 5) {
            \Queue::push('Zbw\Queues\QueueDispatcher@trainingNewExamComment', $comment);
        }
        return $result;
    }

    /**
     *  updates an existing Comment
     * @param $input
     * @return bool
     */
    public function update($input)
    {
        $comment = $this->make()->get($input['id']);
        $comment->content= $input['content'];
        $comment->parent_id = $input['parent_id'];
        $comment->comment_type = $input['comment_type'];
        $comment->author = \Sentry::getUser()->cid;
        return $this->checkAndSave($comment);
    }

    public function rosterComments($cid)
    {
        return $this->make()->where('comment_type', 1)->where('parent_id', $cid)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $input
     * @return void
     */
    public function create($input)
    {

    }
}
