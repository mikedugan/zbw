<?php  namespace Zbw\Users;

use Zbw\Base\EloquentRepository;
use Zbw\Bostonjohn\Emailer;
use Zbw\Users\Contracts\UserRepositoryInterface;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public $model = '\User';

    public function __construct()
    {
    }

    public function findByInitials($initials)
    {
        return $this->make()->where('initials', strtoupper($initials))->first();
    }
    /**
     * @type
     * @name allVitals
     *  returns vital user data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allVitals()
    {
        return $this->make()->all(['first_name', 'last_name', 'cid', 'initials']);
    }

    public function exists($cid)
    {
        return (count($this->make()->find($cid)) === 1);
    }

    /**
     * @param string first name
     * @param string last name
     * @param string email address
     * @param string home artcc
     * @param integer cid
     * @return boolean
     * @deprecated
     */
    public function add($fname, $lname, $email, $artcc, $cid, $rating, $notify = true)
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
        $s = new \UserSettings();
        $s->cid = $u->cid;

        return $u->save() && $s->save();
    }

    /**
     * @name updateUser
     *  updates an existing user
     * @param $input
     * @param null $cid
     * @return bool
     */
    public function updateUser($cid, $input)
    {
        $user = $cid ? \Sentry::findUserById($cid) :\Sentry::findUserById($input['cid']);
        $user->first_name = $input['fname'];
        $user->last_name = $input['lname'];
        $user->initials = $input['initials'];
        $user->artcc = $input['artcc'];

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
        return $this->checkAndSave($user);
    }

    public function authUpdate($user)
    {
        $model = \Sentry::findUserById($user->user->id);
        $model->first_name = $user->user->name_first;
        $model->last_name = $user->user->name_last;
        $model->rating_id = $user->user->rating->id;
        $model->email = $user->user->email;
        $model->save();
    }

    public function activeList()
    {
        return $this->make()->where('activated', 1)->orderBy('updated_at', 'DESC')->get();
    }

    public function active($num = 20)
    {
        return $this->make()->with(['rating', 'settings'])->where('activated', 1)->orderBy('activated', 'DESC')->get();
    }

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
     * @type
     * @name createInitials
     * 
     * @param $fname
     * @param $lname
     * @return string
     */
    public function createInitials($fname, $lname)
    {
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
     * @type
     * @name trainingProgress
     * 
     * @param $id
     * @return float
     */
    public function trainingProgress($id)
    {
        return floor($this->get($id)->cert / 12 * 100);
    }

    /**
     * @type
     * @name search
     * 
     * @param $input
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($input)
    {
        if($input['cid'] != '' && $input['cid'] != null)
        {
            return \User::find($input['cid']);
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

        return $users->get();
    }

    /**
     * @type
     * @name suspendUser
     * 
     * @param $id
     * @return bool
     */
    public function suspendUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = 1;
        $user->is_suspended = 1;
        return $this->checkAndSave($user);
    }

    /**
     * @type
     * @name unsuspendUser
     * 
     * @param $id
     * @return bool
     */
    public function unsuspendUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = true;
        $user->is_suspended = false;
        return $this->checkAndSave($user);
    }

    /**
     * @type
     * @name terminateUser
     * 
     * @param $id
     * @return bool
     */
    public function terminateUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = false;
        $user->is_terminated = true;
        return $this->checkAndSave($user);
    }

    /**
     * @type
     * @name unterminateUser
     * 
     * @param $id
     * @return bool
     */
    public function unterminateUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = true;
        $user->is_terminated = false;
        return $this->checkAndSave($user);
    }

    /**
     * @type
     * @name activateUser
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

    public function getStaff()
    {
        $staff = \Sentry::findGroupByName('Staff');

        return \Sentry::findAllUsersInGroup($staff);
    }

    /**
     * @type
     * @name isStaff
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
     * @type
     * @name isExecutive
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

    public function checkUser($user)
    {
        if(is_int($user)) $user = $this->make()->find($user);
        $status = null;
        if(! $user->activated)
            $status = 'Your account is not active. Please email <a
                   href="mailto:staff@bostonartcc.net">admin</a>';

        return $status;
    }

    public function updateEmailHidden($user, $hidden)
    {
        $user = \Sentry::getUser();
        if($hidden && $hidden === 'true') { $user->settings->email_hidden = 1; }
        else $user->settings->email_hidden = 0;
        return $user->settings->save();
    }

    public function updateAvatar($user, $path)
    {
        $user->settings->avatar = $path;
        return $user->settings->save();
    }

    public function updateNotifications($cid, $input)
    {
        $settings = \UserSettings::where('cid', $cid)->firstOrFail();
        $settings->fill($input);
        return $settings->save();
    }

    public function updateSettings($cid, $input)
    {
        $settings = \UserSettings::where('cid', $cid)->firstOrFail();
        $settings->fill($input);
        return $settings->save();
    }

    public function getAdoptableStudents()
    {
        return $this->make()->where('updated_at', '>', \Carbon::createFromFormat('Y-m-d', '2014-07-27'))->where('adopted_by', null)->where('cid', '!=', 100)->where('cert', 0)->orWhere('cert', 1)->get();
    }

    public function getAdoptedStudents()
    {
        return $this->make()->where('adopted_by', '>', 100)->with(['adopter'])->get();
    }

    public function dropAdopt($student)
    {
        $student = $this->get($student);
        $student->adopted_by = null;
        $student->adopted_on = null;
        return $this->checkAndSave($student);
    }

    public function adopt($student, $staff)
    {
        $student = $this->get($student);
        $student->adopted_by = $staff;
        $student->adopted_on = \Carbon::now();
        return $this->checkAndSave($student);
    }

    public function update($input) {}
    public function create($input) {}
}
