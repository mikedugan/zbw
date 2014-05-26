<?php

class PagesController extends BaseController {
    public function getIndex()
    {
        $data =[

        ];
        return View::make('staff.pages.index', $data);
    }

    public function getCreate()
    {
        return View::make('staff.pages.create');
    }

    public function getMenus()
    {
        return View::make('staff.pages.menus');
    }

    public function getTrash()
    {
        return View::make('staff.pages.trash');
    }

    public function getShow()
    {
        return View::make('staff.pages.show');
    }
}
