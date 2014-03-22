<?php

use Zbw\Repositories\UserRepository;

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
        if($ur->add(Input::get('fname'), Input::get('lname'), Input::get('email'))) {
            return Redirect::back()->with('flash_info', 'Not ready yet!');
        }

        else {
            return Redirect::back()->with('flash_error', 'There was an error!');
        }
    }

}
