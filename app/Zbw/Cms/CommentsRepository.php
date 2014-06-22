<?php  namespace Zbw\Cms;


use Zbw\Base\EloquentRepository;

class CommentsRepository extends EloquentRepository
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
        $comment->author = \Auth::user()->cid;
        return $comment->save();
    }

    public function update($input)
    {

    }

    public function create($input)
    {

    }
}
