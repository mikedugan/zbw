<?php namespace Zbw\Http\Controllers;

use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Illuminate\Session\Store;

use Zbw\Users\Commands\SearchUsersCommand;
use Zbw\Users\Commands\UpdateSettingsCommand;
use Zbw\Users\Commands\UpdateNotificationsCommand;

class UsersController extends BaseController
{

    private $users;
    private $messages;

    public function __construct(Store $store, UserRepositoryInterface $users, MessagesRepositoryInterface $messages)
    {
        $this->users = $users;
        $this->messages = $messages;
        parent::__construct($store);
    }

    //AJAX
    public function getStatus($cid)
    {
        $curl = new \Curl\Curl();
        $curl->get('https://cert.vatsim.net/cert/vatsimnet/idstatus.php?cid=' . $cid);
        return $curl->response;
    }


    public function getIndex()
    {
        return $this->view('zbw.controllers');
    }

    //staff
    public function showUser($id)
    {
        $this->setData('user', $this->users->get($id));
        return $this->view('staff.roster.view');
    }

    public function getController($id)
    {
        if (! $this->users->exists($id)) {
            \App::abort('404');
        }
        $this->setData('controller', $this->users->get($id));
        return $this->view('users.show');
    }

    public function getSearchResults()
    {
        $results = $this->execute(SearchUsersCommand::class, ['input' => $this->input]);
        if (count($results) === 0) {
            //$this->setFlash(['flash_info' => 'No results found']);
            return \Redirect::back()->with('flash_info', 'No results found');
        }
        $this->setData('stype', 'roster');
        $this->setData('results', $results);
        return $this->view('zbw.roster.results');
    }


    /**
     * this route specifically handles when the logged in user navigates to their own profile
     */
    public function getMe()
    {
        $this->setData('messages', $this->messages->to(Auth::user()->cid));
        $this->setData('view', $this->request->get('v'));
        $this->setData('me', \Sentry::getUser()->with(['Exam', 'TrainingSession']));
        return $this->view('users.me.index');
    }

    public function getSettings()
    {
        $this->setData('view', $this->request->get('v'));
        return $this->view('users.me.index');
    }

    public function postSettings()
    {
        if ($this->input['update'] === 'settings') {
            if ($this->execute(UpdateSettingsCommand::class, ['input' => $this->request->except('update')])) {
                $this->setFlash(['flash_success' => 'Settings updated successfully']);
            } else {
                $this->setFlash(['flash_error' => 'Unable to update settings']);
            }

        } else {
            if ($this->input['update'] === 'notifications') {
                if ($this->execute(UpdateNotificationsCommand::class, ['input' => $this->request->except('update')])) {
                    $this->setFlash(['flash_success' => 'Settings updated successfully']);
                } else {
                    $this->setFlash(['flash_error' => 'Unable to update settings']);
                }
            }
        }

        return $this->redirectBack();
    }

    /**
     * @param $id
     * @return string
     */
    public function aSuspend($id)
    {
        if ($this->users->suspendUser($id)) {
            return $this->json(['success' => true, 'message' => 'User suspended']);
        } else {
            return $this->json(['success' => false, 'message' => 'Error suspending user']);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function aTerminate($id)
    {
        if ($this->users->terminateUser($id)) {
            return $this->json(['success' => true, 'message' => 'User terminated']);
        } else {
            return $this->json(['success' => false, 'message' => 'Error terminating user']);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function aActivate($id)
    {
        if ($this->users->activateUser($id)) {
            return $this->json(['success' => true, 'message' => 'User activated']);
        } else {
            return $this->json(['success' => false, 'message' => 'Error activating user']);
        }
    }

    public function aPromote($cid)
    {
        \Queue::push('Zbw\Queues\QueueDispatcher@usersPromote', $cid);
        return $this->json(['success' => true, 'message' => 'User promoted']);
    }

    public function aDemote($cid)
    {
        \Queue::push('Zbw\Queues\QueueDispatcher@usersDemote', $cid);
        return $this->json(['success' => true, 'message' => 'User demoted']);
    }

    /**
     * @param $cid
     * @return string
     */
    public function sendStaffWelcome($cid)
    {
        \Queue::push('Zbw\Queues\QueueDispatcher@usersStaffWelcome', $cid);

        return $this->json(['success' => true, 'message' => "Staff welcome email sent successfully!"]);
    }
}
