<?php namespace Zbw\Cms\Contracts;

interface MessagesRepositoryInterface
{
    public function all();

    public function with($with, $id = null, $pk = 'id', $pagination = null);

    public function get($id, $withTrash = false);

    public function delete($id);

    public function restore($id);

    /**
     * @param array   input
     * @param integer cid
     * @param integer origin message id
     *
     * @return boolean
     */
    public function reply($input, $mid);

    /**
     * @param array   input
     * @param array   users being cc'd
     * @param integer cid of sender
     * @param integer message id
     *
     * @return void
     */
    public function cc($input, $to, $mid);

    /**
     * @type static
     * @name       newMessageCount
     * 
     *
     * @param null $cid
     *
     * @return int
     */
    public static function newMessageCount($cid = null);

    /**
     * @param array $input
     *
     * @return mixed array|boolean
     */
    public function add($input);

    public function create($to, $subject, $message);

    /**
     * @param integer message id
     *
     * @return PrivateMessage
     */
    public function withUsers($id);

    /**
     * @param integer message id
     *
     * @return boolean
     */
    public function markRead($mid);

    /**
     * @param integer cid
     *
     * @return void
     */
    public function markAllRead();

    /**
     * @return Eloquent Collection
     */
    public function trashed();

    /**
     * @param integer user cid
     * @param boolean unread messages only
     *
     * @return Eloquent Collection
     */
    public function to($user, $unread = false);

    /**
     * @param integer user cid
     *
     * @return Eloquent Collection
     */
    public function from($user);

    public function update($input);
}
