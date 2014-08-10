<?php namespace Zbw\Users\Contracts;

/**
 *
 */
interface UserRepositoryInterface
{
    /**
     * @name  findByInitials
     * 
     *
     * @param $initials
     *
     * @return mixed
     */
    public function findByInitials($initials);

    /**
     * @type
     * @name allVitals
     *  returns vital user data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allVitals();

    /**
     * @name       add
     * 
     *
     * @param      $fname
     * @param      $lname
     * @param      $email
     * @param      $artcc
     * @param      $cid
     * @param      $rating
     * @param bool $notify
     *
     * @return mixed
     */
    public function add($fname, $lname, $email, $artcc, $cid, $rating, $notify = true);

    /**
     * @type
     * @name       updateUser
     *  updates an existing user
     *
     * @param      $input
     * @param null $cid
     *
     * @return bool
     */
    public function updateUser($cid, $input);

    /**
     * @name  authUpdate
     * 
     *
     * @param $user
     *
     * @return mixed
     */
    public function authUpdate($user);

    /**
     * @type
     * @name  createInitials
     * 
     *
     * @param $fname
     * @param $lname
     *
     * @return string
     */
    public function createInitials($fname, $lname);

    /**
     * @type
     * @name  search
     * 
     *
     * @param $input
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($input);

    /**
     * @type
     * @name  suspendUser
     * 
     *
     * @param $id
     *
     * @return bool
     */
    public function suspendUser($id);

    /**
     * @type
     * @name  unsuspendUser
     * 
     *
     * @param $id
     *
     * @return bool
     */
    public function unsuspendUser($id);

    /**
     * @type
     * @name  terminateUser
     * 
     *
     * @param $id
     *
     * @return bool
     */
    public function terminateUser($id);

    /**
     * @type
     * @name  unterminateUser
     * 
     *
     * @param $id
     *
     * @return bool
     */
    public function unterminateUser($id);

    /**
     * @type
     * @name  activateUser
     * 
     *
     * @param $id
     *
     * @return bool
     */
    public function activateUser($id);

    /**
     * @name getStaff
     * 
     * @return mixed
     */
    public function getStaff();

    /**
     * @type static
     * @name  canTrain
     * 
     *
     * @param $level
     *
     * @return mixed
     */
    public static function canTrain($level);

    /**
     * @deprecated
     */
    public function canCertify($level);

    /**
     * @name  checkUser
     * 
     *
     * @param $user
     *
     * @return mixed
     */
    public function checkUser($user);

    /**
     * @name  updateSettings
     * 
     *
     * @param $input
     *
     * @return mixed
     */
    public function updateSettings($input);

    /**
     * @name  updateNotifications
     * 
     *
     * @param $input
     *
     * @return mixed
     */
    public function updateNotifications($input);
}
