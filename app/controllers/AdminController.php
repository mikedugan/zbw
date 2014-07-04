<?php 

use Zbw\Users\UserRepository;
use Zbw\Cms\NewsRepository;
use Zbw\Training\TrainingSessionRepository;

class AdminController extends BaseController
{
    private $users;
    private $news;
    private $trainings;

    public function __construct(UserRepository $users, NewsRepository $news, TrainingSessionRepository $trainings)
    {
        $this->users = $users;
        $this->news = $news;
        $this->trainings = $trainings;
    }

    public function getAdminIndex()
    {
        $data = [
        ];
        return View::make('staff.index', $data);
    }
    public function getTrainingIndex()
    {
        $data = [
            'reports' => $this->trainings->recentReports(5),
            'sessions' => ['a', 'b'],
            'requests' => \TrainingRequest::with(['student', 'certType'])->get(),
            'exams' => \Exam::recentExams(5),
        ];
        return View::make('staff.training.index', $data);
    }

    public function getForumIndex()
    {
        $data = [
        ];
        return View::make('staff.forum.index', $data);
    }

    public function getNewsIndex()
    {
        $data = [
            'events' => ['expired' => $this->news->expiredEvents(5) ,
                         'upcoming' => $this->news->upcomingEvents(5),
                         'active' => $this->news->activeEvents(5) ],
            'staffnews' => $this->news->staffNews(5),
            'generalnews' => $this->news->recentNews(5),
            'title' => 'ZBW News Admin'
        ];
        return View::make('staff.pages.news', $data);
    }

    public function getRosterIndex()
    {
        $ur = new UserRepository();
        $view = \Input::get('v');
        $action = \Input::get('action');
        $id = \Input::get('id');
        $data = [
            'users' => $ur->all(),
            'view' => $view,
            'action' => $action,
            'staff' => $ur->getStaff()
        ];
        if($view === 'groups') {
            if(!empty($id) && $action === 'edit') {
                $data['group'] = \Group::find($id);
                $data['members'] = \Sentry::findAllUsersInGroup($data['group']);
            } else {
                $data['groups'] = \Sentry::findAllGroups();
            }
        }

        return View::make('staff.roster.index', $data);
    }

    public function getSearchResults()
    {
        $results = $this->users->search(Input::all());
        $data = [
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
            'user' => $this->users->find($id)
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
