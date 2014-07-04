<?php

use Zbw\Users\UserRepository;
use Zbw\Users\GroupsRepository;

class RosterController extends BaseController {

    private $users;
    private $groups;

    function __construct(UserRepository $users, GroupsRepository $groups)
    {
        $this->users = $users;
        $this->groups = $groups;
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
        if($this->users->create(Input::get('fname'), Input::get('lname'), Input::get('email'), Input::get('artcc'), Input::get('cid'))) {
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

    public function postGroup()
    {
        $input = \Input::all();
        if($this->groups->create($input)) {
            return Redirect::route('roster')->with('flash_success', 'Group created successfully');
        }
        else return Redirect::back()->with('flash_error', 'Error creating group')->withInput();

    }
}
