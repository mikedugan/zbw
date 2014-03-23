<?php  namespace Zbw\Repositories;

use Zbw\Bostonjohn\Emailer;
use Zbw\Helpers;
use Zbw\Bostonjohn\ZbwLog;

class UserRepository
{
    protected $user;
    protected $log;

    public function __construct($user = null)
    {
        $this->user = $user ? \User::find($user) : null;
        $this->log = new ZbwLog();
    }

    public function save()
    {
        return $this->user->save();
    }

    public function getUser($cid = null)
    {
        return $cid == null ? $this->user : \User::find($cid);
    }

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
        $u->rating = 'OBS';
        $u->initials = strtoupper($this->createInitials($fname, $lname));
        if($u->save())
        {
            $em = new Emailer($u, ['password' => $tempPassword]);
            $em->newUser();
            return true;
        }
        else return false;
    }

    public function updateUser($input)
    {
        $this->user->first_name = $input['fname'];
        $this->user->last_name = $input['lname'];
        $this->user->initials = $input['initials'];
        $this->user->artcc = $input['artcc'];
        $this->user->is_mentor = isset($input['ismentor']) ? $input['ismentor'] : 0;
        $this->user->is_instructor = isset($input['isins']) ? $input['isins']: 0;
        $this->user->is_ta = isset($input['is_ta']) ? $input['is_ta'] : 0;
        $this->user->is_webmaster = isset($input['isweb']) ? $input['isweb'] : 0;
        $this->user->is_facilities = isset($input['isfe']) ? $input['isfe'] : 0;
        $this->user->is_atm = isset($input['isatm']) ? $input['isatm'] : 0;
        $this->user->is_datm = isset($input['isdatm']) ? $input['isdatm'] : 0;
        $this->user->is_emeritus = isset($input['isemeritus']) ? $input['isemeritus'] : 0;
        $this->log->addLog(\Auth::user()->initials . " edited " . strtoupper($this->user->initials) . " on " . \Carbon::now() ,'');
        return $this->save();
    }

    public function all()
    {
        return \User::all();
    }

    public function find($id)
    {
        return $id ? \User::find($id) : \User::find($this->user);
    }

    public function createInitials($fname, $lname)
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

    public function cid()
    {
        return $this->user->cid;
    }

    public function name()
    {
        return $this->user->username;
    }


    //returns % of training completed
    public function trainingProgress()
    {
        return floor($this->user->cert / 7 * 100);
    }

    public function rating() { return $this->user->rating; }

    public function cert() { return $this->user->cert; }
    public function certTitle()
    {
        return Helpers::readableCert($this->user->certification['value']);
    }

    public function availableExams($minor = false)
    {
        if($minor) { return "ohshit"; }
        else
        {
            $avail = $this->user->certification->id + 1;
            $title = \CertType::find($avail)->value;
            return [$avail, Helpers::readableCert($title)];
        }
    }

    public function search($input)
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

    public function suspendUser($id)
    {
        $user = \User::find($id);
        $user->is_active = 0;
        if($user->save())
        {
            $this->log->addOverride(Auth::user()->initials . ' suspended ' . $user->initials);
            return true;
        }
        else
        {
            $this->log->addError(Auth::user()->initials . ' had an error attempting to suspend ' . $user->initials);
            return false;
        }
    }

    public function terminateUser($id)
    {
        $user = \User::find($id);
        $user->is_active = -1;
        if($user->save())
        {
            $this->log->addOverride(Auth::user()->initials . ' terminated ' . $user->initials);
            return true;
        }
        else
        {
            $this->log->addError(Auth::user()->initials . ' had an error attempting to terminate ' . $user->initials);
            return false;
        }
    }

    public function isStaff()
    {
        $u = $this->user;
        return $u->is_atm || $u->is_datm || $u->is_ta || $u->is_mentor || $u->is_instructor || $u->is_facilities || $u->is_webmaster;
    }

    public function isExecutive()
    {
        $u = $this->user;
        return $u->is_atm || $u->is_datm || $u->is_ta || $u->is_webmaster;
    }
}
