<?php 

use Zbw\Users\UserRepository;
use Zbw\Cms\NewsRepository;
use Zbw\Training\TrainingSessionRepository;

class AdminController extends BaseController
{
    public function getAdminIndex()
    {
        $data = [
            'title' => 'vZBW Staff Area'
        ];
        return View::make('staff.index', $data);
    }
    public function getTrainingIndex()
    {
        $data = [
            'reports' => TrainingSessionRepository::recentReports(5),
            'sessions' => ['a', 'b'],
            'requests' => \TrainingRequest::with(['student', 'certType'])->get(),
            'exams' => \Exam::recentExams(5),
            'title' => 'vZBW Training Home'
        ];
        JavaScript::put(['foo' => 'mike']);
        return View::make('staff.training.index', $data);
    }

    public function getForumIndex()
    {
        $data = [
            'title' => 'ZBW Forum Admin'
        ];
        return View::make('staff.forum.index', $data);
    }

    public function getNewsIndex()
    {
        $data = [
            'events' => ['expired' => NewsRepository::expiredEvents(5) ,
                         'upcoming' => NewsRepository::upcomingEvents(5),
                         'active' => NewsRepository::activeEvents(5) ],
            'staffnews' => NewsRepository::staffNews(5),
            'generalnews' => NewsRepository::recentNews(5),
            'title' => 'ZBW News Admin'
        ];
        return View::make('staff.pages.news', $data);
    }

    public function getRosterIndex()
    {
        $ur = new UserRepository();
        $data = [
            'title' => 'ZBW Roster Admin',
            'users' => $ur->all(),
            'view' => \Input::get('v'),
            'staff' => $ur->getStaff()
        ];
        return View::make('staff.roster.index', $data);
    }

    public function getSearchResults()
    {
        $ur = new UserRepository();
        $results = $ur->search(Input::all());
        $data = [
            'title' => 'Roster Search Results',
            'stype' => 'roster',
            'results' => $results
        ];
        return View::make('staff.roster.results', $data);
    }

    public function getTsIndex()
    {
        $data = [];
        return View::make('staff.ts', $data);
    }

    public function showUser($id)
    {
        $data = [
            'title' => 'View Controller',
            'user' => UserRepository::find($id)
        ];
        return View::make('staff.roster.view', $data);
    }

    public function getLog()
    {
        $data = [
            'title' => 'View ZBW Log'
        ];
        return View::make('staff.log', $data);
    }
} 
