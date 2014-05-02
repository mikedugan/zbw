<?php  namespace Zbw\Repositories;

use Zbw\Bostonjohn\Emailer;
use Zbw\Helpers;
use Zbw\Bostonjohn\ZbwLog;

class UserRepository
{
    /**
     * @param integer cid
     * @return \User
     */
    public static function find($id)
    {
        return \User::find($id);
    }

    /**
     * @return Collection users with vital info
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
     * @param array input(post)
     * @return boolean success
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
     * @param string controller first name
     * @param string controller last name
     * @return string suggested operating initials
     */
    public static function createInitials($fname, $lname)
    {
        $i = -1;
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
     * @param integer user id
     * @return float training progress
     */
    public static function trainingProgress($id)
    {
        return floor(\User::find($id)->cert / 7 * 100);
    }

    /**
     * @param integer certification id
     * @return string certification title
     */
    public static function certTitle($id)
    {
        return Helpers::readableCert(\User::find($id)->certification['value']);
    }

    /**
     * @param array input data (POST/GET)
     * @return mixed \User|Eloquent\Collection
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
     * @param integer user id
     * @return boolean
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
     * @param integer user id
     * @return boolean
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
     * @param integer user id
     * @return boolean
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
     * @param integer user id
     * @return boolean
     */ 
    public static function isStaff($id)
    {
        $u = \User::find($id);
        return $u->is_atm || $u->is_datm || $u->is_ta || $u->is_mentor || $u->is_instructor || $u->is_facilities || $u->is_webmaster;
    }

    /**
     * @param integer user id
     * @return boolean
     */
    public static function isExecutive($id)
    {
        $u = \User::find($id);
        return $u->is_atm || $u->is_datm || $u->is_ta || $u->is_webmaster;
    }
}
