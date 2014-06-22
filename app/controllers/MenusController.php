<?php

use Zbw\Cms\MenusRepository;

class MenusController extends BaseController {

    private $menus;

    public function __construct(MenusRepository $menus)
    {
        $this->menus = $menus;
    }

    public function getIndex()
    {
        $data =[
            'menus' => $this->menus->all()
        ];
        return View::make('staff.pages.menus.index', $data);
    }

    public function postCreate()
    {
        if($this->menus->add(Input::all()))
            return Redirect::to('/staff')->with('flash_success', 'Menu created successfully');
        else
            return Redirect::back()->with('flash_error', 'Error creating menu');
    }

    public function getUpdate($mid)
    {
        $data =[
            'menu' => $this->menus->find($mid)
        ];
        return View::make('staff.pages.menus.show', $data);
    }

    public function postUpdate($mid)
    {
        $menu = $this->menus->find($mid);
        $menu->fill(Input::all());
        return $menu->save();
    }

    public function postDelete($mid)
    {
        return $this->menus->delete($mid);
    }


}
