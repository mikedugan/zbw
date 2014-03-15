<?php  namespace Zbw\Repositories;

use Zbw\Helpers;

class UserRepository
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user ? \User::find($user) : null;
    }

    public function all()
    {
        return \User::all();
    }

    public function find($id)
    {
        return $id ? \User::find($id) : \User::find($this->user);
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
} 
