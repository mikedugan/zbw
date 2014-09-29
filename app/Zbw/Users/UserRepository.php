<?php  namespace Zbw\Users;

use Zbw\Bostonjohn\Emailer;
use Zbw\Core\EloquentRepository;
use Zbw\Users\Contracts\UserRepositoryInterface;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public $model = '\User';

    /**
     * @param $initials
     * @return mixed
     */
    public function findByInitials($initials)
    {
        return $this->make()->where('initials', strtoupper($initials))->first();
    }
    /**
     *  returns vital user data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allVitals()
    {
        return $this->make()->all(['first_name', 'last_name', 'cid', 'initials']);
    }

    /**
     * @param $cid
     * @return bool
     */
    public function exists($cid)
    {
        return (count($this->make()->find($cid)) === 1);
    }

    /**
     * @param      $fname
     * @param      $lname
     * @param      $email
     * @param      $artcc
     * @param      $cid
     * @param      $rating
     * @param bool $notify
     * @param int  $activated cid
     * @return boolean
     */
    public function add($fname, $lname, $email, $artcc, $cid, $rating, $notify = true, $activated = 1)
    {
        $tempPassword = str_random(20);
        $u = new \User();
        $u->cid = $cid;
        $u->first_name = $fname;
        $u->last_name = $lname;
        $u->username = $fname . ' ' . $lname;
        $u->artcc = $artcc;
        $u->email = $email;
        $u->password = $tempPassword;
        $u->rating_id = $rating;
        $u->initials = $this->createInitials($fname, $lname);
        $u->activated = $activated;
        $s = new \UserSettings();
        $key = new \TsKey(['cid' => $cid, 'ts_key' => $cid, 'expires' => \Carbon::now()->addDay(), 'used' => 0, 'uid' => '', 'status' => 0]);
        $s->cid = $u->cid;
        if($u->save() && $s->save()) {
            $key->save();
            $creator = new SmfUserCreator();
            $creator->create($u);

            $this->flushCache();

            return $u;
        } else {
            return false;
        }
    }

    /**
     * @param string
     * @param string
     * @param string
     * @param string
     * @param integer
     * @param integer
     * @return boolean
     */
    public function addGuest($fname, $lname, $email, $artcc, $cid, $rating)
    {
        $tempPassword = str_random(20);
        $u = new \User();
        $u->cid = $cid;
        $u->first_name = $fname;
        $u->last_name = $lname;
        $u->username = $fname . ' ' . $lname;
        $u->artcc = $artcc;
        $u->email = $email;
        $u->guest = 1;
        $u->activated = 1;
        $u->password = $tempPassword;
        $u->rating_id = $rating;
        $u->initials = $this->createInitials($fname, $lname);
        $s = new \UserSettings();
        $s->cid = $u->cid;
        if($u->save() && $s->save()) {
            $creator = new SmfUserCreator();
            $creator->create($u);

            $this->flushCache();

            return $u;
        } else {
            return false;
        }
    }

    /**
     *  updates an existing user
     * @param $input
     * @param null $cid
     * @return bool
     */
    public function updateUser($cid, $input)
    {
        $user = $cid ? \Sentry::findUserById($cid) : \Sentry::findUserById($input['cid']);
        $user->first_name = $input['fname'];
        $user->last_name = $input['lname'];
        $user->initials = $input['initials'];
        $user->artcc = $input['artcc'];
        $user->rating_id = $input['rating_id'];
        $user->cert = $input['cert'];

        if(isset($input['ismentor'])) {
            $user->addGroup(\Sentry::findGroupByName('Mentors'));
        } else {
            $user->removeGroup(\Sentry::findGroupByName('Mentors'));
        }
        if(isset($input['isins'])) {
            $user->addGroup(\Sentry::findGroupByName('Instructors'));
        } else {
            $user->removeGroup(\Sentry::findGroupByName('Instructors'));
        }
        if(isset($input['is_ta'])) {
            $user->addGroup(\Sentry::findGroupByName('TA'));
        } else {
            $user->removeGroup(\Sentry::findGroupByName('TA'));
        }
        if(isset($input['isweb'])) {
            $user->addGroup(\Sentry::findGroupByName('Web'));
        } else {
            $user->removeGroup(\Sentry::findGroupByName('Web'));
        }
        if(isset($input['isfe'])) {
            $user->addGroup(\Sentry::findGroupByName('FE'));
        } else {
            $user->removeGroup(\Sentry::findGroupByName('FE'));
        }
        if(isset($input['isatm'])) {
            $user->addGroup(\Sentry::findGroupByName('ATM'));
        } else {
            $user->removeGroup(\Sentry::findGroupByName('ATM'));
        }
        if(isset($input['isdatm'])) {
            $user->addGroup(\Sentry::findGroupByName('DATM'));
        } else {
            $user->removeGroup(\Sentry::findGroupByName('DATM'));
        }
        if(isset($input['isemeritus'])) {
            $user->addGroup(\Sentry::findGroupByName('Emeritus'));
        } else {
            $user->removeGroup(\Sentry::findGroupByName('Emeritus'));
        }

        $old_groups = $user->groups->lists('id');
        $new_groups = [];
        $counter = 0;
        if(!empty($input['groups'])) {
            foreach ($input['groups'] as $id) {
                $new_groups[] = \Sentry::findGroupById($id);
                $counter++;
            }
            foreach ($new_groups as $group) {
                $user->addGroup($group);
                $counter++;
            }
            if(!empty($old_groups)) {
                foreach($old_groups as $old) {
                    $delete = true;
                    foreach($new_groups as $new) {
                        if($new->id == $old) { $delete = false; }
                        $counter++;
                    }
                    if($delete) { $user->removeGroup(\Sentry::findGroupById($old)); }
                }
            }
        } else if(empty($new_groups)) {
            foreach($old_groups as $group) {
                $user->removeGroup(\Sentry::findGroupById($group));
                $counter++;
            }
        }

        if($user->isDirty()) {
            $this->flushCache(null, ['all', $user->initials, $user->cid]);
        }

        return $this->checkAndSave($user);
    }

    /**
     * @param $user
     * @return void
     */
    public function authUpdate($user)
    {
        $model = \Sentry::findUserById($user->user->id);
        $model->first_name = $user->user->name_first;
        $model->last_name = $user->user->name_last;
        $model->rating_id = $user->user->rating->id;
        $model->email = $user->user->email;

        if($model->isDirty()) {
            $this->flushCache(null, ['all', $user->initials, $user->cid]);
        }

        $model->save();
    }

    /**
     * @return mixed
     */
    public function activeList()
    {
        return $this->make()->where('activated', 1)->orderBy('updated_at', 'DESC')->get();
    }

    /**
     * @param int $num
     * @return mixed
     */
    public function active($num = 20)
    {
        return $this->make()->with(['rating', 'settings'])->where('activated', 1)->orderBy('activated', 'DESC')->get();
    }

    /**
     * @param \Zbw\Core\relations $with
     * @param null                $id
     * @param string              $pk
     * @param null                $pagination
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function with($with, $id = null, $pk = 'id', $pagination = null)
    {
        if($pagination) {
            return $this->make()->with($with)->orderBy('activated', 'DESC')->orderBy('initials', 'ASC')->paginate($pagination);
        } else if($id) {
            return $this->make()->where($pk, $id)->with($with)->firstOrFail();
        }
        return $this->make()->with($with)->get();
    }

    /**
     * 
     * @param $fname
     * @param $lname
     * @return string
     */
    public function createInitials($fname, $lname)
    {
        if($lname instanceof \SimpleXMLElement) {
            $lname = $lname->__toString();
        }
        //todo - make this check for and use inactive initials
        for($i = -1; $i >= '-'.strlen($lname); $i--)
        {
            $preferred = $lname[0] . substr($lname, $i, 1);
            if(count($this->make()->where('initials', '=', $preferred)->get()) == 0)
            {
                return strtoupper($preferred);
            }
        }
        for($i = -1; $i >= '-'.strlen($fname); $i--)
        {
            $preferred = $lname[0] . substr($fname, $i, 1);
            if(count($this->make()->where('initials', '=', $preferred)->get()) == 0)
            {
                return strtoupper($preferred);
            }
        }
    }

    /**
     * 
     * @param $id
     * @return float
     */
    public function trainingProgress($id)
    {
        return floor($this->get($id)->cert / 12 * 100);
    }

    /**
     * 
     * @param $input
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($input)
    {
        if($input['cid'] != '' && $input['cid'] != null)
        {
            return \User::find($input['cid']);
        } else if(! empty($input['oi'])) {
            return $this->findByinitials($input['oi']);
        }

        $users = $this->make()->where('cid', '>', 0);
        if($input['email'] != null && $input['email'] != '')
        {
            $em = $input['email'];
            $users = $users->where('email', 'LIKE', "%$em%");
        }

        if($input['rating'] != null && $input['rating'] != '')
        {
            $users = $users->where('rating_id', $input['rating']);
        }

        if($input['fname'] != null && $input['fname'] != '')
        {
            $fn = $input['fname'];
            $users = $users->where('first_name', 'LIKE', "%$fn%");
        }

        if($input['lname'] != null && $input['lname'] != '')
        {
            $ln = $input['lname'];
            $users = $users->where('last_name', 'LIKE', "%$ln%");
        }

        return $users->where('terminated', 0)->get();
    }

    /**
     * 
     * @param $id
     * @return bool
     */
    public function suspendUser($id)
    {
        $user = $this->make()->find($id);
        $user->activated = 1;
        return $this->checkAndSave($user);
    }

    /**
     * 
     * @param $id
     * @return bool
     */
    public function unsuspendUser($id)
    {
        $user = $this->make()->find($id);
        $user->activated = 1;
        return $this->checkAndSave($user);
    }

    /**
     * 
     * @param $id
     * @return bool
     */
    public function terminateUser($id)
    {
        $user = $this->make()->find($id);
        $user->activated = 0;
        $user->terminated = 1;
        return $this->checkAndSave($user);
    }

    /**
     * 
     * @param $id
     * @return bool
     */
    public function unterminateUser($id)
    {
        $user = $this->make()->find($id);
        $user->activated = 1;
        $user->terminated = 0;
        return $this->checkAndSave($user);
    }

    /**
     * 
     * @param $id
     * @return bool
     */
    public function activateUser($id)
    {
        $user = $this->make()->find($id);
        $user->activated = 1;
        return $this->checkAndSave($user);
    }

    /**
     * @return array
     */
    public function getStaff()
    {
        $staff = \Sentry::findGroupByName('Staff');

        return $staff->users()->with(['rating', 'settings'])->get();
    }

    public function getSingleStaff($group)
    {
        $staff = \Sentry::findGroupByName($group);
        return $staff->users()->with(['rating','settings'])->select(['rating_id','cid','username','initials','email'])->first();
    }

    /**
     * @deprecated
     * 
     * @param $id
     * @return bool
     */
    public function isStaff($id)
    {
        $u = $this->make()->find($id);
        $staff = \Sentry::findGroupByName('Staff');
        return $u->inGroup($staff);
    }

    /**
     * @deprecated
     * 
     * @param $id
     * @return bool
     */
    public function isExecutive($id)
    {
        $u = $this->make()->find($id);
        $exec = \Sentry::findGroupByName('Executive');
        return $u->inGroup($exec);
    }

    /**
     * @param string $col
     * @return mixed
     */
    public static function canTrain($level, $col = 'cid')
    {
        $start = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('Mentors'));
        $start = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('Instructors'))->merge($start);
        foreach ($start as $index => $user) {
            if($level == 11) {
                if($user->cert <= 11) unset($start[$index]);
            }
            else {
                if($user->cert < $level + 2) unset($start[$index]);
            }
        }
        return $start->lists('cid');
    }

    /**
     * @deprecated
     */
    public function canCertify($level, $col = 'cid')
    {
        if($level == 11) { return $this->make()->where('cert', '>=', 12)->lists($col); }
        else if ($level == 12) { return $this->make()->where('cert', '>=', 13)->lists($col); }
        return $this->make()->where('cert', '>=', $level + 2)->lists($col);
    }

    /**
     * @param $user
     * @return null|string
     */
    public function checkUser($user)
    {
        if(is_int($user)) $user = $this->make()->find($user);
        $status = null;
        if(! $user->activated)
            $status = 'Your account is not active. Please email <a
                   href="mailto:staff@bostonartcc.net">admin</a>';

        return $status;
    }

    /**
     * @param $user
     * @param $hidden
     * @return mixed
     */
    public function updateEmailHidden($user, $hidden)
    {
        $user = \Sentry::getUser();
        if($hidden && $hidden === 'true') { $user->settings->email_hidden = 1; }
        else $user->settings->email_hidden = 0;
        return $user->settings->save();
    }

    /**
     * @param $user
     * @param $path
     * @return mixed
     */
    public function updateAvatar($user, $path)
    {
        $user->settings->avatar = $path;
        return $user->settings->save();
    }

    /**
     * @param $cid
     * @param $input
     * @return bool
     */
    public function updateNotifications($cid, $input)
    {
        $settings = \UserSettings::where('cid', $cid)->firstOrFail();
        $settings->fill($input);
        return $settings->save();
    }

    /**
     * @param $cid
     * @param $input
     * @return bool
     */
    public function updateSettings($cid, $input)
    {
        $settings = \UserSettings::where('cid', $cid)->firstOrFail();
        $settings->fill($input);
        return $settings->save();
    }

    /**
     * @return mixed
     */
    public function getAdoptableStudents()
    {
        return $this->make()->where('created_at', '>', '2014-08-01 00:00:00')->where('adopted_by', null)->where('cid', '!=', 100)->where('cert', 0)->orWhere('cert', 1)->get();
    }

    /**
     * @return mixed
     */
    public function getAdoptedStudents()
    {
        return $this->make()->where('adopted_by', '>', 100)->with(['adopter'])->get();
    }

    /**
     * @param $student
     * @return bool
     */
    public function dropAdopt($student)
    {
        $student = $this->get($student);
        $student->adopted_by = null;
        $student->adopted_on = null;
        return $this->checkAndSave($student);
    }

    /**
     * @param $student
     * @param $staff
     * @return bool
     */
    public function adopt($student, $staff)
    {
        $student = $this->get($student);
        $student->adopted_by = $staff;
        $student->adopted_on = \Carbon::now();
        return $this->checkAndSave($student);
    }

    public function getInactive()
    {
        //get all the users where cid in (select all from staffing where cid and last_login > (now - 60 days ago)
        $limit = \Carbon::now()->subDays(60);
        $users = \DB::select("SELECT DISTINCT(cid) FROM zbw_staffing WHERE start > \"$limit\"");
        $safe = [];
        array_map(function($obj) use (&$safe) {
            array_push($safe, $obj->cid);
        }, $users);

        array_push($safe, 100);

        $users = $this->make()->whereNotIn('cid', $safe)->get();
        return $users;
    }

    public function getPaginatedRoster($pag = 15)
    {
        return $this->make()->with(['rating','settings'])->orderBy('activated', 'DESC')->orderBy('last_name', 'ASC')->paginate($pag);
    }

    public function findByFirstLastName($first_name, $last_name)
    {
        return $this->make()->where('first_name', $first_name)->where('last_name', $last_name)->get();
    }

    /**
     * @param $input
     * @return void
     */
    public function update($input) {}

    /**
     * @param $input
     * @return void
     */
    public function create($input) {}
}
