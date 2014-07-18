<?php
use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

class UsersController extends BaseController
{

    private $users;
    private $messages;

    public function __construct(UserRepositoryInterface $users, MessagesRepositoryInterface $messages)
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

    //staff
    public function showUser($id)
    {
        $data = [
          'user' => $this->users->get($id)
        ];
        return View::make('staff.roster.view', $data);
    }

    public function getController($id)
    {
        $data = [
          'controller' => $this->users->get($id)
        ];

        return View::make('users.show', $data);
    }

    public function getSearchResults()
    {
        $results = $this->users->search(Input::all());
        $data = [
          'stype' => 'roster',
          'results' => $results
        ];
        if(count($results) === 0) {
            return Redirect::back()->with('flash_info', 'No results found');
        }
        return View::make('zbw.roster.results', $data);
    }


    /**
     * this route specifically handles when the logged in user navigates to their own profile
     */
    public function getMe()
    {
        $data = [
          'messages' => $this->messages->to(Auth::user()->cid),
          'view'     => \Input::get('v'),
          'me'       => \Sentry::getUser()->with(['Exam', 'TrainingSession'])
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
        $update_type = \Input::get('update');
        if($update_type === 'settings') {
            if ($this->users->updateSettings(\Input::except('update'))) {
                return Redirect::back()->with('flash_success','Settings updated successfully');
            } else {
                return Redirect::back()->with(
                  'flash_error',
                  'Unable to update settings!'
                );
            }
        }

        else if ($update_type === 'notifications') {
            if($this->users->updateNotifications(\Input::except('update'))) {
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
