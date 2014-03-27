<?php

class NewsController extends BaseController {
    public function getCreate()
    {
        $data = [
            'title' => 'Add Event'
        ];
        return View::make('staff.news.create', $data);
    }
}
