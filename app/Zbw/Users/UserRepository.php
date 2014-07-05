<?php  namespace Zbw\Users;

use Zbw\Base\EloquentRepository;
use Zbw\Bostonjohn\Emailer;
use Zbw\Base\Helpers;
use Zbw\Bostonjohn\ZbwLog;

class UserRepository extends EloquentRepository
{
    public $model = '\User';

    public function __construct()
    {
    }

    public function findByInitials($initials)
    {
        return $this->make()->where('initials', strtoupper($initials))->first();
    }

    public function findByCid($cid)
    {
        return $this->make()->where('cid', $cid)->first();
    }

    /**
     * @type
     * @name allVitals
     * @description returns vital user data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allVitals()
    {
        return $this->make()->all(['first_name', 'last_name', 'cid', 'initials']);
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
    public function add($fname, $lname, $email, $artcc, $cid)
    {
        $tempPassword = Helpers::createPassword();

        $u = new \User();
        $u->cid = $cid;
        $u->first_name = $fname;
        $u->last_name = $lname;
        $u->username = $fname . ' ' . $lname;
        $u->artcc = $artcc;
        $u->email = $email;
        $u->password = \Hash::make($tempPassword);
        $u->rating_id = -1;
        $u->initials = strtoupper(UserRepository::createInitials($fname, $lname));

        $s = new \UserSettings();
        $s->cid = $u->cid;

        if($u->save() && $s->save())
        {
            $em = new Emailer($u, ['password' => $tempPassword]);
            $em->newUser($u);
            return true;
        }
        else return false;
    }

    /**
     * @type
     * @name updateUser
     * @description updates an existing user
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
        $user->is_mentor = isset($input['ismentor']) ? $input['ismentor'] : 0;
        $user->is_instructor = isset($input['isins']) ? $input['isins']: 0;
        $user->is_ta = isset($input['is_ta']) ? $input['is_ta'] : 0;
        $user->is_webmaster = isset($input['isweb']) ? $input['isweb'] : 0;
        $user->is_facilities = isset($input['isfe']) ? $input['isfe'] : 0;
        $user->is_atm = isset($input['isatm']) ? $input['isatm'] : 0;
        $user->is_datm = isset($input['isdatm']) ? $input['isdatm'] : 0;
        $user->is_emeritus = isset($input['isemeritus']) ? $input['isemeritus'] : 0;
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
        dd($counter);
        return $user->save();
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

    /**
     * @type
     * @name createInitials
     * @description
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
                return $preferred;
            }
        }
        for($i = -1; $i >= '-'.strlen($fname); $i--)
        {
            $preferred = $lname[0] . substr($fname, $i, 1);
            if(count($this->make()->where('initials', '=', $preferred)->get()) == 0)
            {
                return $preferred;
            }
        }
    }

    /**
     * @type
     * @name trainingProgress
     * @description
     * @param $id
     * @return float
     */
    public function trainingProgress($id)
    {
        return floor($this->make()->find($id)->cert / 7 * 100);
    }

    /**
     * @type
     * @name certTitle
     * @description
     * @param $id
     * @return string
     */
    public function certTitle($id)
    {
        return Helpers::readableCert($this->make()->find($id)->certification['value']);
    }

    /**
     * @type
     * @name search
     * @description
     * @param $input
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($input)
    {
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

        if($input['cid'] > 0)
        {
            return $this->make()->find($input['cid']);
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

    public function userLoginUpdate($cid, $data)
    {
        $user = $this->make()->find($cid);
        $user->email = $data['email'];
        return $user->save();
    }

    /**
     * @type
     * @name suspendUser
     * @description
     * @param $id
     * @return bool
     */
    public function suspendUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = 1;
        $user->is_suspended = 1;
        if($user->save())
        {
            ZbwLog::override(\Auth::user()->initials . ' suspended ' . $user->initials);
            return true;
        }
        else
        {
            ZbwLog::error(\Auth::user()->initials . ' had an error attempting to suspend ' . $user->initials);
            return false;
        }
    }

    /**
     * @type
     * @name unsuspendUser
     * @description
     * @param $id
     * @return bool
     */
    public function unsuspendUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = true;
        $user->is_suspended = false;
        if($user->save())
        {
            ZbwLog::override(\Auth::user()->initials . ' un-suspended ' . $user->initials);
            return true;
        }
        else
        {
            ZbwLog::error(\Auth::user()->initials . ' had an error attempting to un-suspend ' . $user->initials);
            return false;
        }
    }

    /**
     * @type
     * @name terminateUser
     * @description
     * @param $id
     * @return bool
     */
    public function terminateUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = false;
        $user->is_terminated = true;
        if($user->save())
        {
            ZbwLog::log(\Auth::user()->initials . ' terminated ' . $user->initials);
            return true;
        }
        else
        {
            ZbwLog::error(\Auth::user()->initials . ' had an error attempting to terminate ' . $user->initials);
            return false;
        }
    }

    /**
     * @type
     * @name unterminateUser
     * @description
     * @param $id
     * @return bool
     */
    public function unterminateUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = true;
        $user->is_terminated = false;
        if($user->save())
        {
            ZbwLog::log(\Auth::user()->initials . ' un-terminated ' . $user->initials);
            return true;
        }
        else
        {
            ZbwLog::error(\Auth::user()->initials . ' had an error attempting to un-terminate ' . $user->initials);
            return false;
        }
    }


    /**
     * @type
     * @name activateUser
     * @description
     * @param $id
     * @return bool
     */
    public function activateUser($id)
    {
        $user = $this->make()->find($id);
        $user->is_active = 1;
        if($user->save())
        {
            ZbwLog::override(\Auth::user()->initials . ' activated ' . $user->initials);
            return true;
        }
        else
        {
            ZbwLog::error(\Auth::user()->initials . ' had an error attempting to activate ' . $user->initials);
            return false;
        }
    }

    public function getStaff()
    {
        return $this->make()->where('is_staff', 1)->orWhere('is_mentor', 1)->orWhere('is_instructor', 1)->get();
    }

    /**
     * @type
     * @name isStaff
     * @description
     * @param $id
     * @return bool
     */
    public function isStaff($id)
    {
        $u = $this->make()->find($id);
        return $u->is_atm || $u->is_datm || $u->is_ta || $u->is_mentor || $u->is_instructor || $u->is_facilities || $u->is_webmaster;
    }

    /**
     * @type
     * @name isExecutive
     * @description
     * @param $id
     * @return bool
     */
    public function isExecutive($id)
    {
        $u = $this->make()->find($id);
        return $u->is_atm || $u->is_datm || $u->is_ta || $u->is_webmaster;
    }

    public static function canTrain($level)
    {
        if($level == 12) {
            return \User::where('cert', '>=', 12)->lists('cid');
        } else {
            return \User::where('cert', '>=', $level + 1)->lists('cid');
        }

    }

    public function canCertify($level)
    {
        if($level == 11) { return $this->make()->where('cert', '>=', 12)->lists('cid'); }
        else if ($level == 12) { return $this->make()->where('cert', '>=', 13)->lists('cid'); }
        return $this->make()->where('cert', '>=', $level + 2)->lists('cid');
    }

    public function checkUser($user)
    {
        if(is_int($user)) $user = $this->make()->find($user);
        $status = null;
        if(! $user->is_active)
            $status = 'Your account is not active. Please email <a
                   href="mailto:staff@bostonartcc.net">admin</a>';

        return $status;
    }

    public function update($input)
    {

    }

    public function create($input)
    {

    }

    public function updateSettings($input)
    {
        $u = \Sentry::getUser();
        if(isset($input['email_hidden']) && $input['email_hidden'] === 'true') $input['email_hidden'] = 1;
        else $input['email_hidden'] = 0;
        unset($input['avatar']);
        $u->settings->fill($input);
        if(\Input::hasFile('avatar')) {
            $path = public_path().'/uploads/avatars/';
            $avatar = \Input::file('avatar');
            $avatar->move($path, $u->cid . '.' . $avatar->getClientOriginalExtension());
            $u->settings->avatar = '/uploads/avatars/'.$u->cid.'.'.$avatar->getClientOriginalExtension();
        }
        return $u->save() && $u->settings->save();
    }

    public function updateNotifications($input)
    {
        $settings = \UserSettings::where('cid', \Sentry::getUser()->cid)->firstOrFail();
        $settings->fill($input);
        return $settings->save();
    }
}
