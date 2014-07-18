<?php

use Zbw\Cms\Contracts\PagesRepositoryInterface;
use Zbw\Cms\Contracts\MenusRepositoryInterface;

class PagesController extends BaseController {

	private $pages;
    private $menus;

	public function __construct(PagesRepositoryInterface $pages, MenusRepositoryInterface $menus) {
		$this->pages = $pages;
      $this->menus = $menus;
	}

	public function getIndex() {
		$v    = \Input::get('v');
		$data = [
			'v' => $v,
            'pages' => $this->pages->all(),
            'menus' => $this->menus->all()
		];
		return View::make('staff.pages.index', $data);
	}

	public function getPage($slug) {
      $page = $this->pages->slug($slug);
      if($page->audience_type_id == 4 && ! \Sentry::getUser()->inGroup(\Sentry::findGroupByName('Staff'))) {
          $data = [
              'page' => \Request::url(),
              'needed' => 'Staff'
          ];
          return View::make('zbw.errors.403', $data);
      }
		$data = [
			'page' => $page
		];
		return View::make('cms.pages.show', $data);
	}

	public function getCreate() {
		return View::make('staff.pages.create');
	}

	public function postCreate() {
		if($this->pages->create(\Input::all())) {
        return Redirect::route('staff/pages')->with('flash_success', 'Page created successfully');
    } else {
        return Redirect::back()->with('flash_error', 'Error creating page');
    }
	}

	public function getMenus() {
		return View::make('staff.pages.menus');
	}

	public function getTrash() {
		return View::make('staff.pages.trash');
	}

	public function getShow() {
		return View::make('staff.pages.show');
	}
}
