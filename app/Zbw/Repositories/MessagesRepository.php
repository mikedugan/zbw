<?php namespace Zbw\Repositories;

use Zbw\Facades\ZbwValidator;
use Zbw\Interfaces\EloquentRepositoryInterface;

class MessagesRepository implements EloquentRepositoryInterface {

    /**
     * @type static
     * @name find
     * @description
     * @param int $id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static
     */
    static function find($id, $relations = [])
    {
        return \PrivateMessage::with($relations)->find($id);
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
    static function reply($input, $mid)
    {
        $invalid = ZbwValidator::get('PrivateMessage', $input);
        if(is_array($invalid)) return $invalid;

        $m = \PrivateMessage::create([
            'subject' => $input['subject'],
            'content' => $input['content'],
            'to' => $input['to'],
            'from' => \Auth::user()->cid,
            'history' => $input['history']
        ]);
        if(isset($input['forget_history']) && $input['forget_history'] === 'forget') { $m->history = '';}
        return $m->save();
    }

    /**
     * @param array input
     * @param array users being cc'd
     * @param integer cid of sender
     * @param integer message id
     * @return void
     */
    static function cc($input, $to, $mid)
    {
        $to = explode(',', str_replace(' ', '', $to));
        foreach($to as $user)
        {
            $input['to'] = $user;
            $input['from'] = \Auth::user()->cid;
            MessagesRepository::reply($input, $mid);
        }
    }

    /**
     * @type static
     * @name newMessageCount
     * @description
     * @param null $cid
     * @return int
     */
    static function newMessageCount($cid = null)
    {
        $cid = is_null($cid) ? Auth::user()->cid : $cid;
        return \PrivateMessage::where('to', $cid)->where('is_read', 0)->get(['id'])->count();
    }

    /**
     * @param array $input
     * @return mixed array|boolean
     */
    static function add($input)
    {

    }

    /**
     * @param integer message id
     * @return PrivateMessage
     */
    static function withUsers($id)
    {
        return \PrivateMessage::with(['sender', 'recipients'])->where('id', $id)->firstOrFail();
    }

    /**
     * @param integer message id
     * @return boolean
     */
    static function markRead($mid)
    {
        $message = \PrivateMessage::find($mid);
        $message->is_read = 1;
        return $message->save();
    }

    /**
     * @param integer cid
     * @return void
     */
    static function markAllRead($cid)
    {
        foreach(\PrivateMessage::where('to', $cid)->get() as $message)
        {
            $message->is_read = 1;
        }

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
        return $unread ? $messages->where('is_read', 0)->get() : $messages->get();
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
