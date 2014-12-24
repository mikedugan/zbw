<?php namespace Zbw\Http\Controllers;

use Illuminate\Session\Store;
use Zbw\Teamspeak\TeamspeakService;

class TeamspeakController extends BaseController
{
    private $ts;

    public function __construct(TeamspeakService $ts, Store $session)
    {
        parent::__construct($session);
        $this->ts = $ts;
    }

    public function getIndex()
    {
        $this->setData('users', $this->ts->connectedZbwUsers());
        return $this->view('staff.teamspeak.index');
    }

    public function postKick($cid)
    {
        $this->ts->kick($cid, \Input::get('message'));
        return $this->redirectBack()->with('flash_success', 'Client kicked');
    }

    public function postMessage($cid)
    {
        $this->ts->message($cid, \Input::get('message'));
        return $this->redirectBack()->with('flash_success', 'Message sent');
    }
}
