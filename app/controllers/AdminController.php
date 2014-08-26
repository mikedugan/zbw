<?php 

use Zbw\Users\Contracts\UserRepositoryInterface;

class AdminController extends BaseController
{
    private $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function getAdminIndex()
    {
        return View::make('staff.index');
    }


    public function getForumIndex()
    {
        return View::make('staff.forum.index');
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
