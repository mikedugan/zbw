<?php

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
    	$i = Input::all();
    	return Redirect::to('/')->with('flash_success', 'Event added');
    }
}
