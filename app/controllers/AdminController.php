<?php 

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
            'reports' => ControllerTraining::recentReports(5),
            'sessions' => ['a', 'b'],
            'requests' => ['c', 'd'],
            'exams' => ControllerExam::recentExams(5),
            'title' => 'vZBW Training Home'
        ];
        return View::make('training.admin.index', $data);
    }

    public function getForumIndex()
    {
        $data = [
            'title' => 'ZBW Forum Admin'
        ];
        return View::make('staff.forum', $data);
    }

    public function getCmsIndex()
    {
        $data = [
            'title' => 'ZBW CMS Admin'
        ];
        return View::make('staff.cms', $data);
    }

    public function getNewsIndex()
    {
        $data = [
            'title' => 'ZBW News Admin'
        ];
        return View::make('staff.news', $data);
    }

    public function getRosterIndex()
    {
        $data = [ 'title' => 'ZBW Roster Admin'];
        return View::make('staff.roster', $data);
    }

    public function getTsIndex()
    {
        $data = [ 'title' => 'ZBW TS Admin'];
        return View::make('staff.ts', $data);
    }
} 
