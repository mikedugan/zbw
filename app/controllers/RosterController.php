<?php

use Illuminate\Session\Store;
use Zbw\Users\Contracts\GroupsRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

class RosterController extends BaseController
{

    private $users;
    private $groups;
    private $visitors;

    function __construct(UserRepositoryInterface $users, GroupsRepositoryInterface $groups, VisitorApplicantRepositoryInterface $visitors, Store $session)
    {
        $this->users = $users;
        $this->groups = $groups;
        $this->visitors = $visitors;
        parent::__construct($session);
    }

    public function getPublicRoster()
    {
        $view = \Input::get('v');
        $action = \Input::get('action');
        $id = \Input::get('id');
        $pag = 15;
        $users = '';
        if($view !== 'staff') {
            if (\Input::has('num') && \Input::get('num') === 'active') {
                $users = $this->users->active($pag);
            } else {
                if (\Input::has('num')) {
                    $pag = \Input::get('num');
                    $users = $this->users->with(['rating', 'settings'], null, 'cid', $pag);
                } else {
                    $pag = 20;
                    $users = $this->users->with(['rating', 'settings'], null, 'cid', $pag);
                }
            }
        }
        $data = [
          'users'       => $users,
          'view'        => $view,
          'action'      => $action,
          'instructors' => \Sentry::findGroupByName('Instructors'),
          'staff'       => \Sentry::findGroupByName('Staff'),
          'mentors'     => \Sentry::findGroupByName('Mentors'),
          'executive'   => \Sentry::findGroupByName('Executive')
        ];
        if ($view === 'staff') {
            $data['staff_users'] = $this->users->getStaff();
            $data['events'] = $this->users->getSingleStaff('Events');
            $data['web'] = $this->users->getSingleStaff('WEB');
            $data['fe'] = $this->users->getSingleStaff('FE');
            $data['atm'] = $this->users->getSingleStaff('ATM');
            $data['datm'] = $this->users->getSingleStaff('DATM');
            $data['ta'] = $this->users->getSingleStaff('TA');
        }
        if ($view === 'groups') {
            if ( ! empty($id) && $action === 'edit') {
                $data['group'] = \Group::find($id);
                $data['members'] = \Sentry::findAllUsersInGroup($data['group']);
            } else {
                $data['groups'] = \Sentry::findAllGroups();
            }
        }

        return View::make('zbw.roster.index', $data);
    }

    public function getAdminIndex()
    {
        $view = \Input::get('v');
        $action = \Input::get('action');
        $id = \Input::get('id');
        $pag = 15;
        $users = '';
        if($view !== 'staff') {
            if (\Input::has('num') && \Input::get('num') === 'active') {
                $users = $this->users->active($pag);
            } else {
                if (\Input::has('num')) {
                    $pag = \Input::get('num');
                    $users = $this->users->with(['rating', 'settings'], null, 'cid', $pag);
                } else {
                    $users = $this->users->with(['rating', 'settings'], null, 'cid', $pag);
                }
            }
        }
        $data = [
          'users'  => $users,
          'view'   => $view,
          'action' => $action,
          'instructors' => \Sentry::findGroupByName('Instructors')->users->lists('cid'),
          'staff'       => \Sentry::findGroupByName('Staff')->users->lists('cid'),
          'mentors'     => \Sentry::findGroupByName('Mentors')->users->lists('cid'),
          'executive'   => \Sentry::findGroupByName('Executive')->users->lists('cid')
        ];
        if ($view === 'staff') {
            $data['staff_users'] = $this->users->getStaff();
            $data['events'] = $this->users->getSingleStaff('Events');
            $data['web'] = $this->users->getSingleStaff('WEB');
            $data['fe'] = $this->users->getSingleStaff('FE');
            $data['atm'] = $this->users->getSingleStaff('ATM');
            $data['datm'] = $this->users->getSingleStaff('DATM');
            $data['ta'] = $this->users->getSingleStaff('TA');
        }
        if ($view === 'groups') {
            if ( ! empty($id) && $action === 'edit') {
                $data['group'] = \Group::find($id);
                $data['members'] = \Sentry::findAllUsersInGroup($data['group']);
            } else {
                $data['groups'] = \Sentry::findAllGroups();
            }
        }
        if ($view === 'visitor') {
            $data['applicants'] = \VisitorApplicant::all();
        }
        if ($view === 'adopt') {
            $data['students'] = $this->users->getAdoptableStudents();
            $data['adopted'] = $this->users->getAdoptedStudents();
        }

        return View::make('staff.roster.index', $data);
    }

    public function getAddController()
    {
        $data = [
          'title' => 'Add ZBW Controller'
        ];

        return View::make('staff.roster.create-controller', $data);
    }

    public function postAddController()
    {
        if ($this->users->create(Input::get('fname'), Input::get('lname'), Input::get('email'), Input::get('artcc'), Input::get('cid'))) {
            return Redirect::back()->with('flash_info', 'Controller successfully added!');
        } else {
            return Redirect::back()->with('flash_error', 'There was an error!');
        }
    }

    public function getEditUser($id)
    {
        $data = [
          'user'   => \User::find($id),
          'groups' => $this->groups->all()
        ];

        return View::make('staff.roster.edit', $data);
    }

    public function postEditUser($id)
    {
        if ($this->users->updateUser($id, Input::all())) {
            return Redirect::back()->with('flash_success', 'User successfully updated!');
        } else {
            return Redirect::back()->with('flash_error', 'There was an error - postEditUser');
        }
    }

    public function postGroup()
    {
        $input = \Input::all();
        if ($this->groups->create($input)) {
            return Redirect::route('roster')->with('flash_success', 'Group created successfully');
        } else {
            return Redirect::back()->with('flash_error', 'Error creating group')->withInput();
        }

    }

    public function updateGroup()
    {
        if ($this->groups->updateGroup(\Input::all())) {
            return Redirect::back()->with('flash_success', 'Group updated');
        } else {
            return Redirect::back()->with('flash_error', 'Unable to update group');
        }
    }

    public function postVisitorDeny()
    {
        $staff = \Sentry::getUser();
        if ($results = $this->visitors->deny($staff, \Input::all())) {
            Queue::push('Zbw\Bostonjohn\Queues\QueueDispatcher@usersDenyVisitor', $results);

            return Redirect::back()->with('flash_success', 'Visitor request denied');
        } else {
            return Redirect::back()->with('flash_error', $this->visitors->getErrors());
        }
    }

    public function postVisitorLor()
    {
        $staff = \Sentry::getUser();
        if ($this->visitors->addLor($staff, \Input::all())) {
            return Redirect::back()->with('flash_success', 'LOR uploaded successfully');
        } else {
            return Redirect::back()->with('flash_error', $this->visitors->getErrors());
        }
    }

    public function postVisitorComment()
    {
        $staff = \Sentry::getUser();
        if ($comment = $this->visitors->comment($staff, \Input::all())) {
            return Redirect::back()->with('flash_success', 'Comment added successfully');
        } else {
            return Redirect::back()->with('flash_error', $this->visitors->getErrors());
        }
    }

    public function postVisitorDelete($id)
    {
        if ($this->visitors->delete($id)) {
            return Redirect::back()->with('flash_success', 'Applicant deleted successfully');
        } else {
            return Redirect::back()->with('flash_error', 'Error deleting applicant');
        }
    }
}
