<?php 

class AdminController extends BaseController
{
    public function getAdminIndex()
    {
        $data = [
            'title' => 'vZBW Staff Area'
        ];
        return View::make('admin.index', $data);
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
} 
