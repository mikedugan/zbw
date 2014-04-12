<?php

use Zbw\Validators\NewsValidator;
use Zbw\Repositories\NewsRepository;

class NewsController extends BaseController {

    public function getCreate()
    {
        $data = [
            'title' => 'Add Event'
        ];
        return View::make('staff.news.create', $data);
    }

    public function postCreate()
    {
        $errors = NewsRepository::add(Input::all());
    	if(is_array($errors))
        {
            return Redirect::back()->with('flash_error', $errors)->withInput();
        }

        else
        {
            return Redirect::home()->with('flash_success', 'Event created successfully!');
        }
    }
}
