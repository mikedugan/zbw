<?php

use Illuminate\Session\Store;
use Zbw\Users\Contracts\UserRepositoryInterface;

class AdminController extends BaseController
{
    private $users;

    public function __construct(UserRepositoryInterface $users, Store $session)
    {
        $this->users = $users;
        parent::__construct($session);
    }

    public function getAdminIndex()
    {
        $this->view('staff.index');
    }


    public function getForumIndex()
    {
        $this->view('staff.forum.index');
    }

    public function getSearchResults()
    {
        $results = $this->users->search(Input::all());
        $this->setData('stype', 'roster');
        $this->setData('results', $results);

        if(count($results) === 0) {
            return Redirect::back()->with('flash_info', 'No results found');
        }
        $this->view('staff.roster.results');
    }

    public function getTsIndex()
    {
        $this->view('staff.ts');
    }

    public function getLog()
    {
        $this->view('staff.log');
    }
} 
