<?php  namespace Zbw\Repositories;

use Zbw\Bostonjohn\Emailer;
use Zbw\Helpers;
use Zbw\Bostonjohn\ZbwLog;

class UserRepository
{

    /**
     * @type static
     * @name find
     * @description
     * @param $id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static
     */
    public static function find($id, array $relations = [])
    {
        return \User::with($relations)->find($id);
    }

    public static function findByInitials($initials)
    {
        $initials = str_replace(' ', '', strtoupper($initials));
        return \User::where('initials', $initials)->first();
    }

    public static function findByCid($cid)
    {
        return \User::where('cid', $cid)->first();
    }

    /**
     * @type static
     * @name allVitals
     * @description returns vital user data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allVitals()
    {
        return \User::all(['first_name', 'last_name', 'cid', 'initials']);
    }

    /**
     * @param string first name
     * @param string last name
     * @param string email address
     * @param string home artcc
     * @param integer cid
     * @return boolean
     */
    public static function add($fname, $lname, $email, $artcc, $cid)
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
        $u->rating = 'OBS';
        $u->initials = strtoupper(UserRepository::createInitials($fname, $lname));
        if($u->save())
        {
            $em = new Emailer($u, ['password' => $tempPassword]);
            $em->newUser();
            return true;
        }
        else return false;
    }

    /**
     * @type static
     * @name updateUser
     * @description updates an existing user
     * @param $input
     * @param null $cid
     * @return bool
     */
    public static function updateUser($input, $cid = null)
    {
        $user = $cid ? \User::find($cid) : \User::find($input['cid']);
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
        return $user->save();
    }

    /**
     * @return eloquent collection
     */
    public static function all()
    {
        return \User::all();
    }

    /**
     * @type static
     * @name createInitials
     * @description
     * @param $fname
     * @param $lname
     * @return string
     */
    public static function createInitials($fname, $lname)
    {
        //todo - make this check for and use inactive initials
        for($i = -1; $i >= '-'.strlen($lname); $i--)
        {
            $preferred = $lname[0] . substr($lname, $i, 1);
            if(count(\User::where('initials', '=', $preferred)->get()) == 0)
            {
                return $preferred;
            }
        }
        for($i = -1; $i >= '-'.strlen($fname); $i--)
        {
            $preferred = $lname[0] . substr($fname, $i, 1);
            if(count(\User::where('initials', '=', $preferred)->get()) == 0)
            {
                return $preferred;
            }
        }
    }

    /**
     * @type static
     * @name trainingProgress
     * @description
     * @param $id
     * @return float
     */
    public static function trainingProgress($id)
    {
        return floor(\User::find($id)->cert / 7 * 100);
    }

    /**
     * @type static
     * @name certTitle
     * @description
     * @param $id
     * @return string
     */
    public static function certTitle($id)
    {
        return Helpers::readableCert(\User::find($id)->certification['value']);
    }

    /**
     * @type static
     * @name search
     * @description
     * @param $input
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function search($input)
    {
        $users = \User::where('cid', '>', 0);
        if($input['email'] != null && $input['email'] != '')
        {
            $em = $input['email'];
            $users = $users->where('email', 'LIKE', "%$em%");
        }

        if($input['rating'] != null && $input['rating'] != '')
        {
            $users = $users->where('rating', '=', strtoupper($input['rating']));
        }

        if($input['cid'] > 0)
        {
            return \User::find($input['cid']);
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
     * @type static
     * @name suspendUser
     * @description
     * @param $id
     * @return bool
     */
    public static function suspendUser($id)
    {
        $user = \User::find($id);
        $user->is_active = 0;
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
     * @type static
     * @name terminateUser
     * @description
     * @param $id
     * @return bool
     */
    public static function terminateUser($id)
    {
        $user = \User::find($id);
        $user->is_active = -1;
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
     * @type static
     * @name activateUser
     * @description
     * @param $id
     * @return bool
     */
    public static function activateUser($id)
    {
        $user = \User::find($id);
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

    /**
     * @type static
     * @name isStaff
     * @description
     * @param $id
     * @return bool
     */
    public static function isStaff($id)
    {
        $u = \User::find($id);
        return $u->is_atm || $u->is_datm || $u->is_ta || $u->is_mentor || $u->is_instructor || $u->is_facilities || $u->is_webmaster;
    }

    /**
     * @type static
     * @name isExecutive
     * @description
     * @param $id
     * @return bool
     */
    public static function isExecutive($id)
    {
        $u = \User::find($id);
        return $u->is_atm || $u->is_datm || $u->is_ta || $u->is_webmaster;
    }

    public static function canTrain($level)
    {
        if($level == 12) {
            return \User::where('cert', '>=' ,12)->lists('cid');
        } else {
            return \User::where('cert', '>=', $level + 1)->lists('cid');
        }

    }

    public static function canCertify($level)
    {
        if($level == 11) { return \User::where('cert', '>=', 12)->lists('cid'); }
        else if ($level == 12) { return \User::where('cert', '>=', 13)->lists('cid'); }
        return \User::where('cert', '>=', $level + 2)->lists('cid');
    }
}
