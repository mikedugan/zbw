<?php 

use Zbw\Users\UserRepository;

class AdminController extends BaseController
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getAdminIndex()
    {
        $data = [
        ];
        return View::make('staff.index', $data);
    }


    public function getForumIndex()
    {
        $data = [
        ];
        return View::make('staff.forum.index', $data);
    }

    public function getSearchResults()
    {
        $results = $this->users->search(Input::all());
        $data = [
            'stype' => 'roster',
            'results' => $results
        ];
        if(empty($results[0])) {
            return Redirect::back()->with('flash_info', 'No results found');
        }
        return View::make('staff.roster.results', $data);
    }

    public function getTsIndex()
    {
        $data = [];
        return View::make('staff.ts', $data);
    }

    public function getLog()
    {
        $data = [
            'title' => 'View ZBW Log'
        ];
        return View::make('staff.log', $data);
    }
} 
