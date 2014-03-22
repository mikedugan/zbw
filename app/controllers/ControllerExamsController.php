<?php

class ControllerExamsController extends BaseController {

	public function getStaffReview($eid)
    {
        $data = [
            'title' => 'Review Exam',
            'exam' => \ControllerExam::with(['student'])->find($eid)
        ];
        return View::make('staff.exams.review', $data);
    }
}
