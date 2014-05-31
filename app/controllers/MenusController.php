<?php

use Zbw\Cms\MenusRepository;

class MenusController extends BaseController {
    public function getIndex()
    {
        $data =[
            'menus' => MenusRepository::all()
        ];
        return View::make('staff.pages.menus.index', $data);
    }

    public function postCreate()
    {
        if(MenusRepository::add(Input::all()))
            return Redirect::to('/staff')->with('flash_success', 'Menu created successfully');
        else
            return Redirect::back()->with('flash_error', 'Error creating menu');
    }

    public function getUpdate($mid)
    {
        $data =[
            'menu' => MenusRepository::find($mid)
        ];
        return View::make('staff.pages.menus.show', $data);
    }

    public function postUpdate($mid)
    {
        $menu = MenusRepository::find($mid);
        $menu->fill(Input::all());
        return $menu->save();
    }

    public function postDelete($mid)
    {
        return MenusRepository::delete($mid);
    }


}
