<?php

use Zbw\Forums\ForumsRepository;

class ForumsController extends BaseController
{

    private $forums;
    public function __construct(ForumsRepository $forums)
    {
        $this->forums = $forums;
    }

    public function getIndex()
    {
        $data = [
          'title' => 'vZBW Forums',
          'recent' => '',
          'hot' => '',
          'new' => '',
        ];
        return View::make('forums.index', $data);
    }

    public function getForum($id)
    {
        $data = [
          'topic' => ForumsRepository::find($id),
          'permissions' => ''
        ];

        return View::make('forums.show', $data);
    }

    public function getCreate()
    {
        $data = [

        ];

        return View::make('forums.create');
    }

    public function postCreate()
    {
        $input = \Input::all();
        if ($this->forums->create($input)) {
            return Redirect::route('forums')->with(
              'flash_success',
              'Forum successfully created!'
            );
        } else {
            return Redirect::back()->with(
              'flash_error',
              'Error creating forum'
            );
        }
    }

    public function getSettings()
    {
        $data = [
          'forums' => $this->forums->all(),
        ];

        return View::make('forums.settings', $data);
    }

    public function postSettings()
    {
        $input = \Input::all();
        if (ForumsRepository::updateSettings($input)) {
            return Redirect::route('forums/settings')->with(
              'flash_success',
              'Settings updated successfully'
            );
        } else {
            return Redirect::back()->with(
              'flash_error',
              'Error updating settings!'
            );
        }
    }

}
