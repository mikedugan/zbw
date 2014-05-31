<?php

use Zbw\Users\UserRepository;

class RosterController extends BaseController {

    public function getAddController()
    {
        $data = [
            'title' => 'Add ZBW Controller'
        ];
        return View::make('staff.roster.add-controller', $data);
    }

    public function postAddController()
    {
        $ur = new UserRepository();
        if($ur->add(Input::get('fname'), Input::get('lname'), Input::get('email'), Input::get('artcc'), Input::get('cid'))) {
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
        $ur = new UserRepository($id);
        if($ur->updateUser(Input::all()))
        {
            return Redirect::back()->with('flash_success', 'User successfully updated!');
        }
        else return Redirect::back()->with('flash_error', 'There was an error - postEditUser');
    }
}
