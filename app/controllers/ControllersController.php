<?php
use Zbw\Cms\MessagesRepository;
use Zbw\Users\UserRepository;

class ControllersController extends BaseController
{

    private $users;
    private $messages;

    public function __construct(UserRepository $users, MessagesRepository $messages)
    {
        $this->users = $users;
        $this->messages = $messages;
    }

    public function getIndex()
    {
        $data = [
        ];
        return View::make('zbw.controllers');
    }

    public function getController($id)
    {
        $data = [
          'controller' => $this->users->find($id, ['certification'])
        ];

        return View::make('users.show', $data);

    }

    /**
     * this route specifically handles when the logged in user navigates to their own profile
     */
    public function getMe()
    {
        $data = [
          'messages' => $this->messages->to(Auth::user()->cid),
          'view'     => \Input::get('v'),
          'me'       => \Auth::user()->with(['Exam', 'TrainingSession'])
        ];
        return View::make('users.me.index', $data);
    }

    public function getSettings()
    {
        $data = [
          'view' => \Input::get('v')
        ];
        return View::make('users.me.index', $data);
    }

    public function postSettings()
    {
        $update_type = \Input::get('update_type');
        if($update_type === 'profile') {
            return Redirect::back()->with('flash_error', 'Unable to update settings!');
        }

        else if ($update_type === 'settings') {
            if($this->users->updateSettings(\Input::all())) {
                return Redirect::back()->with('flash_success', 'Settings updated');
            } else {
                return Redirect::back()->with('flash_error', 'Unable to update settings!');
            }
        } else {
            return Redirect::back()->with('flash_error', 'Unable to update settings!');
        }

    }

    public function view($cid)
    {

    }

}
