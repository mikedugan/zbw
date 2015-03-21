<?php


namespace Zbw\Users\Contracts;

use Zbw\Users\cid;
use Zbw\Users\email;
use Zbw\Users\first;
use Zbw\Users\home;
use Zbw\Users\last;

interface UserRepositoryInterface
{
    public function findByInitials($initials);

    /**
     * @type
     * @name allVitals
     *  returns vital user data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allVitals();

    public function exists($cid);

    /**
     * @param string  first name
     * @param string  last name
     * @param string  email address
     * @param string  home artcc
     * @param integer cid
     * @return boolean
     * @deprecated
     */
    public function add($fname, $lname, $email, $artcc, $cid, $rating, $notify = true);

    /**
     * @name       updateUser
     *  updates an existing user
     * @param      $input
     * @param null $cid
     * @return bool
     */
    public function updateUser($cid, $input);

    public function authUpdate($user);

    public function activeList();

    public function active($num = 20);

    public function with($with, $id = null, $pk = 'id', $pagination = null);

    /**
     * @type
     * @name  createInitials
     * @param $fname
     * @param $lname
     * @return string
     */
    public function createInitials($fname, $lname);

    /**
     * @type
     * @name  trainingProgress
     * @param $id
     * @return float
     */
    public function trainingProgress($id);

    /**
     * @type
     * @name  search
     * @param $input
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($input);

    /**
     * @type
     * @name  suspendUser
     * @param $id
     * @return bool
     */
    public function suspendUser($id);

    /**
     * @type
     * @name  unsuspendUser
     * @param $id
     * @return bool
     */
    public function unsuspendUser($id);

    /**
     * @type
     * @name  terminateUser
     * @param $id
     * @return bool
     */
    public function terminateUser($id);

    /**
     * @type
     * @name  unterminateUser
     * @param $id
     * @return bool
     */
    public function unterminateUser($id);

    /**
     * @type
     * @name  activateUser
     * @param $id
     * @return bool
     */
    public function activateUser($id);

    public function getStaff();

    /**
     * @type
     * @name  isStaff
     * @deprecated
     * @param $id
     * @return bool
     */
    public function isStaff($id);

    /**
     * @type
     * @name  isExecutive
     * @deprecated
     * @param $id
     * @return bool
     */
    public function isExecutive($id);

    public static function canTrain($level, $col = 'cid');

    /**
     * @deprecated
     */
    public function canCertify($level, $col = 'cid');

    public function checkUser($user);

    public function updateEmailHidden($user, $hidden);

    public function updateAvatar($user, $path);

    public function updateNotifications($cid, $input);

    public function getAdoptableStudents();

    public function getAdoptedStudents();

    public function dropAdopt($student);

    public function adopt($student, $staff);

    public function update($input);

    public function create($input);
}
