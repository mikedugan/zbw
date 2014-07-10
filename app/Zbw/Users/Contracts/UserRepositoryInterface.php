<?php namespace Zbw\Users\Contracts;

interface UserRepositoryInterface
{
    public function findByInitials($initials);

    /**
     * @type
     * @name allVitals
     * @description returns vital user data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allVitals();

    /**
     * @param string  first name
     * @param string  last name
     * @param string  email address
     * @param string  home artcc
     * @param integer cid
     *
     * @return boolean
     * @deprecated
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

    public function getStaff();

    public static function canTrain($level);

    /**
     * @deprecated
     */
    public function canCertify($level);

    public function checkUser($user);

    public function updateSettings($input);

    public function updateNotifications($input);
}
