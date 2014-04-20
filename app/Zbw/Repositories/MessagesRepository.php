<?php namespace Zbw\Repositories;

class MessagesRepository implements Zbw\Interfaces\EloquentRepositoryInterface {
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
        return $withTrash == true ? \PrivateMessage::withTrashed() : \PrivateMessage::all();
    }

    /**
     * @param array $input
     * @return mixed array|boolean
     */
    static function add($input)
    {

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
    public static function inbox($user, $unread = false)
    {
        $messages = \PrivateMessage::all()->userInbox($user);
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
