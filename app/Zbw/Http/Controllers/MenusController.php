<?php

namespace Zbw\Http\Controllers;

use Input;
use Zbw\Cms\MenusRepository;
use Zbw\Http\Controllers\BaseController;

class MenusController extends BaseController
{

    private $menus;

    public function __construct(MenusRepository $menus, \Illuminate\Session\Store $session)
    {
        parent::__construct($session);
        $this->menus = $menus;
    }

    public function getIndex()
    {
        $this->setData('menus', $this->menus->all());
        return $this->view('staff.pages.menus.index');
    }

    public function postCreate()
    {
        if ($this->menus->add(Input::all())) {
            return \Redirect::to('/staff')->with('flash_success', 'Menu created successfully');
        } else {
            return \Redirect::back()->with('flash_error', 'Error creating menu');
        }
    }

    public function getUpdate($mid)
    {
        $this->setData('menu', $this->menus->find($mid));
        return $this->view('staff.pages.menus.show');
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
