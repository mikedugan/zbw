<?php namespace Zbw\Users\Contracts;

/**
 *
 */
interface UserRepositoryInterface
{
    /**
     * @name  findByInitials
     * @description
     *
     * @param $initials
     *
     * @return mixed
     */
    public function findByInitials($initials);

    /**
     * @type
     * @name allVitals
     * @description returns vital user data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allVitals();

    /**
     * @name       add
     * @description
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
     * @description updates an existing user
     *
     * @param      $input
     * @param null $cid
     *
     * @return bool
     */
    public function updateUser($cid, $input);

    /**
     * @name  authUpdate
     * @description
     *
     * @param $user
     *
     * @return mixed
     */
    public function authUpdate($user);

    /**
     * @type
     * @name  createInitials
     * @description
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
     * @description
     *
     * @param $input
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($input);

    /**
     * @type
     * @name  suspendUser
     * @description
     *
     * @param $id
     *
     * @return bool
     */
    public function suspendUser($id);

    /**
     * @type
     * @name  unsuspendUser
     * @description
     *
     * @param $id
     *
     * @return bool
     */
    public function unsuspendUser($id);

    /**
     * @type
     * @name  terminateUser
     * @description
     *
     * @param $id
     *
     * @return bool
     */
    public function terminateUser($id);

    /**
     * @type
     * @name  unterminateUser
     * @description
     *
     * @param $id
     *
     * @return bool
     */
    public function unterminateUser($id);

    /**
     * @type
     * @name  activateUser
     * @description
     *
     * @param $id
     *
     * @return bool
     */
    public function activateUser($id);

    /**
     * @name getStaff
     * @description
     * @return mixed
     */
    public function getStaff();

    /**
     * @type static
     * @name  canTrain
     * @description
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
     * @description
     *
     * @param $user
     *
     * @return mixed
     */
    public function checkUser($user);

    /**
     * @name  updateSettings
     * @description
     *
     * @param $input
     *
     * @return mixed
     */
    public function updateSettings($input);

    /**
     * @name  updateNotifications
     * @description
     *
     * @param $input
     *
     * @return mixed
     */
    public function updateNotifications($input);
}
