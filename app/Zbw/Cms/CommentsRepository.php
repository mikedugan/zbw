<?php  namespace Zbw\Cms;


use Zbw\Base\EloquentRepository;
use Zbw\Cms\Contracts\CommentsRepositoryInterface;

class CommentsRepository extends EloquentRepository implements CommentsRepositoryInterface
{
    public $model = '\Comment';
    public static function add($input)
    {
        $comment = new \Comment(
          [
            'content'      => $input['content'],
            'parent_id'    => $input['parent_id'],
            'comment_type' => $input['comment_type'],
          ]
        );
        $comment->author = \Sentry::getUser()->cid;
        return $comment->save();
    }

    public function update($input)
    {

    }

    public function create($input)
    {

    }
}
