<?php namespace Zbw\Repositories;

use Zbw\Facades\ZbwValidator;
use Zbw\Interfaces\EloquentRepositoryInterface;

class MessagesRepository implements EloquentRepositoryInterface {
    /**
     * @param integer $id
     * @return mixed
     */
    static function find($id)
    {
        return \PrivateMessage::find($id);
    }

    /**
     * @param boolean include soft-deleted?
     * @return \Zbw\Interfaces\EloquentCollection
     */
    static function all($withTrash = false)
    {
        return $withTrash == true ? \PrivateMessage::withTrashed()->get() : \PrivateMessage::all();
    }

    /**
     * @param array input
     * @param integer cid
     * @param integer origin message id
     * @return boolean
     */
    static function reply($input, $cid, $mid)
    {
        $invalid = ZbwValidator::get('PrivateMessage', $input);
        if(is_array($invalid)) return $invalid;

        $m = \PrivateMessage::create([
            'subject' => $input['subject'],
            'content' => $input['content'],
            'to' => $input['to']
        ]);
        $m->from = \Auth::user()->cid;
        return $m->save();
    }

    /**
     * @param array input
     * @param array users being cc'd
     * @param integer cid of sender
     * @param integer message id
     * @return void
     */
    static function cc($input, $to, $cid, $mid)
    {
        $to = explode(',', str_replace(' ', '', $to));
        foreach($to as $user)
        {
            $input['to'] = $user;
            MessagesRepository::reply($input, $cid, $mid);
        }
    }

    /**
     * @param array $input
     * @return mixed array|boolean
     */
    static function add($input)
    {

    }

    static function withUsers($id)
    {
        return \PrivateMessage::with(['sender', 'recipients'])->where('id', $id)->firstOrFail();
    }

    /**
     * @return Eloquent Collection
     */
    public static function trashed()
    {
        return \PrivateMessage::onlyTrashed();
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public static function delete($id)
    {
        return \PrivateMessage::destroy($id);
    }

    /**
     * @param integer user cid
     * @param boolean unread messages only
     * @return Eloquent Collection
     */
    public static function to($user, $unread = false)
    {
        $messages = \PrivateMessage::where('to', $user);
        return $unread ? $messages->unread()->get() : $messages->get();
    }

    /**
     * @param integer user cid
     * @return Eloquent Collection
     */
    public static function outbox($user)
    {
        return \PrivateMessage::all()->userOutbox($user)->get();
    }

}
