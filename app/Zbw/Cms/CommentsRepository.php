<?php  namespace Zbw\Cms;

class CommentsRepository
{
    public static function all()
    {
        return \ZbwComment::all();
    }

    public static function find($id)
    {
        return \ZbwComment::find($id);
    }

    public static function add($input)
    {
        $comment = new \ZbwComment([
            'content' => $input['content'],
            'parent_id' => $input['parent_id'],
            'comment_type' => $input['comment_type'],
        ]);
        $comment->author = \Auth::user()->cid;
        return $comment->save();
    }

    public static function delete($id)
    {
        return \ZbwComment::destroy($id);
    }
} 
