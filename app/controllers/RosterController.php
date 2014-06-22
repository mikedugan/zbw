<?php

use Zbw\Users\UserRepository;

class RosterController extends BaseController {

    private $users;

    function __construct(UserRepository $users)
    {
        $this->users = $users;
    }


    public function getAddController()
    {
        $data = [
            'title' => 'Add ZBW Controller'
        ];
        return View::make('staff.roster.create-controller', $data);
    }

    public function postAddController()
    {
        if($this->users->add(Input::get('fname'), Input::get('lname'), Input::get('email'), Input::get('artcc'), Input::get('cid'))) {
            return Redirect::back()->with('flash_info', 'Controller successfully added!');
        }

        else {
            return Redirect::back()->with('flash_error', 'There was an error!');
        }
    }

    public function getEditUser($id)
    {
        $data = [
            'user' => \User::find($id),
            'title' => 'Edit Controller'
        ];
        return View::make('staff.roster.edit', $data);
    }

    public function postEditUser($id)
    {
        if($this->users->updateUser(Input::all()))
        {
            return Redirect::back()->with('flash_success', 'User successfully updated!');
        }
        else return Redirect::back()->with('flash_error', 'There was an error - postEditUser');
    }
}
