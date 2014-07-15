<?php

use Zbw\Cms\Contracts\PagesRepositoryInterface;

class PagesController extends BaseController {

	private $pages;

	public function __construct(PagesRepositoryInterface $pages) {
		$this->pages = $pages;
	}

	public function getIndex() {
		$v    = \Input::get('v');
		$data = [
			'v' => $v,
		];
		return View::make('staff.pages.index', $data);
	}

	public function getPage($slug) {
		$data = [
			'page' => $this->pages->slug($slug)
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
