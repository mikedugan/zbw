<?php  namespace Zbw\Cms;

class CommentsRepository
{
    public static function all()
    {
        return \Comment::all();
    }

    public static function find($id)
    {
        return \Comment::find($id);
    }

    public static function add($input)
    {
        $comment = new \Comment([
            'content' => $input['content'],
            'parent_id' => $input['parent_id'],
            'comment_type' => $input['comment_type'],
        ]);
        $comment->author = \Auth::user()->cid;
        return $comment->save();
    }

    public static function delete($id)
    {
        return \Comment::destroy($id);
    }
} 
