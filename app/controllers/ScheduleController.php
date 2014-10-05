<?php

use Zbw\Users\Contracts\ScheduleRepositoryInterface;
use Illuminate\Session\Store;

class ScheduleController extends \BaseController
{
    private $schedules;

    public function __construct(ScheduleRepositoryInterface $schedules, Store $session)
    {
        $this->schedules = $schedules;
        parent::__construct($session);
    }

    public function getIndex()
    {
        $this->setData('schedules', $this->schedules->all());
        return $this->view('zbw.schedules.index');
    }

    public function postIndex()
    {
        $input = \Input::all();
        $input['cid'] = $this->current_user->cid;
        $this->schedules->create($input);
        $this->setFlash(['flash_success' => 'Scheduled for '.$input['start']]);
        return $this->redirectBack();
    }

    public function getDelete($id)
    {
        $schedule = $this->schedules->get($id);
        if($schedule->cid !== $this->current_user->cid) {
            $this->setFlash(['flash_error' => 'Operation not allowed']);
            return $this->redirectBack();
        }

        $this->schedules->delete($id);
        $this->setFlash(['flash_success' => 'Schedule entry deleted successfully']);
        return $this->redirectBack();
    }
} 
