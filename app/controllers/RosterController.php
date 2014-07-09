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

    public function getPublicRoster()
    {
        $view = \Input::get('v');
        $action = \Input::get('action');
        $id = \Input::get('id');
        $pag = 10;
        if(\Input::has('num')) $pag = \Input::get('num');
        $data = [
          'users' => $this->users->with(['rating'], null, 'cid', $pag),
          'view' => $view,
          'action' => $action,
          'staff' =>  $this->users->getStaff()
        ];
        if($view === 'groups') {
            if(!empty($id) && $action === 'edit') {
                $data['group'] = \Group::find($id);
                $data['members'] = \Sentry::findAllUsersInGroup($data['group']);
            } else {
                $data['groups'] = \Sentry::findAllGroups();
            }
        }

        return View::make('zbw.roster.index', $data);
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
            'groups' => $this->groups->all(),
            'title' => 'Edit Controller'
        ];
        return View::make('staff.roster.edit', $data);
    }

    public function postEditUser($id)
    {
        if($this->users->updateUser($id, Input::all()))
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

    public function updateGroup()
    {
        if($this->groups->updateGroup(\Input::all())) {
            return Redirect::back()->with('flash_success', 'Group updated');
        } else {
            return Redirect::back()->with('flash_error', 'Unable to update group');
        }
    }
}
