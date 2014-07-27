<?php  namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;
use Zbw\Cms\Contracts\CommentsRepositoryInterface;

class CommentsRepository extends EloquentRepository implements CommentsRepositoryInterface
{
    public $model = '\Comment';

    /**
     * @description creates a new Comment
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
        return $this->checkAndSave($comment);
    }

    /**
     * @description updates an existing Comment
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

    public function create($input)
    {

    }
}
