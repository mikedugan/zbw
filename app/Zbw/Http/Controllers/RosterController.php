<?php namespace Zbw\Http\Controllers;

use Illuminate\Session\Store;
use Queue;
use Zbw\Cms\Contracts\CommentsRepositoryInterface;
use Zbw\Users\Contracts\GroupsRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;
use Zbw\Bostonjohn\Datafeed\VatusaExamFeed;

class RosterController extends BaseController
{

    private $users;
    private $groups;
    private $visitors;
    private $comments;
    private $examFeed;

    function __construct(
        UserRepositoryInterface $users,
        GroupsRepositoryInterface $groups,
        VisitorApplicantRepositoryInterface $visitors,
        CommentsRepositoryInterface $comments,
        VatusaExamFeed $examFeed,
        Store $session
    ) {
        $this->users = $users;
        $this->groups = $groups;
        $this->visitors = $visitors;
        $this->comments = $comments;
        $this->examFeed = $examFeed;
        parent::__construct($session);
    }

    public function getPublicRoster()
    {
        $view = $this->request->get('v');
        $action = $this->request->get('action');
        $id = $this->request->get('id');
        $pag = 15;
        $users = '';
        if ($view !== 'staff') {
            if ($this->request->has('num') && $this->request->get('num') === 'active') {
                $users = $this->users->active($pag);
            } else {
                if ($this->request->has('num')) {
                    $pag = $this->request->get('num');
                    $users = $this->users->make()->with(['rating', 'settings'])->
                    where('activated', 1)->where('terminated', 0)
                        ->orderBy('last_name', 'ASC')->paginate($pag);
                } else {
                    $pag = 20;
                    $users = $this->users->make()->with(['rating', 'settings'])
                        ->where('activated', 1)->where('terminated', 0)
                        ->orderBy('last_name', 'ASC')->paginate($pag);
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
            if (! empty($id) && $action === 'edit') {
                $data['group'] = \Group::find($id);
                $data['members'] = \Sentry::findAllUsersInGroup($data['group']);
            } else {
                $data['groups'] = \Sentry::findAllGroups();
            }
        }

        return \View::make('zbw.roster.index', $data);
    }

    public function getAdminIndex()
    {
        $view = $this->request->get('v');
        $action = $this->request->get('action');
        $id = $this->request->get('id');
        $users = '';
        if ($view !== 'staff') {
            $users = $this->users->getPaginatedRoster();
        }
        $data = [
            'users'       => $users,
            'view'        => $view,
            'action'      => $action,
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
            if (! empty($id) && $action === 'edit') {
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
            $data['mine'] = $this->users->getAdoptedByCid($this->current_user->cid);
        }

        if ($view === 'inactive') {
            $staffings = \App::make('Zbw\Users\StaffingRepository');
            $data['users'] = $this->users->getInactive();
            $data['staffings'] = $staffings->getMostRecentAll();
        }
        return \View::make('staff.roster.index', $data);
    }

    public function getAddController()
    {
        $data = [
            'title' => 'Add ZBW Controller'
        ];

        return \View::make('staff.roster.create-controller', $data);
    }

    public function postAddController()
    {
        if ($this->users->create($this->request->get('fname'), $this->request->get('lname'),
            $this->request->get('email'), $this->request->get('artcc'), $this->request->get('cid'))
        ) {
            return \Redirect::back()->with('flash_info', 'Controller successfully added!');
        } else {
            return \Redirect::back()->with('flash_error', 'There was an error!');
        }
    }

    public function getControllerDashboard($cid)
    {
        $this->setData('controller', $this->users->get($cid));
        $this->setData('comments', $this->comments->rosterComments($cid));
        return $this->view('staff.roster.dashboard');
    }

    public function getEditUser($id)
    {
        $this->setData('user', $this->users->get($id));
        $this->setData('groups', $this->groups->all());
        $this->setData('certs', \CertType::all());
        $this->setData('ratings', \Rating::all());
        $this->setData('comments', $this->comments->rosterComments($id));
        $this->view('staff.roster.edit');
    }

    public function postEditUser($id)
    {
        if ($this->users->updateUser($id, $this->request->all())) {
            return \Redirect::back()->with('flash_success', 'User successfully updated!');
        } else {
            return \Redirect::back()->with('flash_error', 'There was an error - postEditUser');
        }
    }

    public function postRosterComment($cid)
    {
        $this->comments->add([
            'comment_type' => 1,
            'parent_id'    => $cid,
            'content'      => $this->request->get('comment')
        ]);
        return \Redirect::back()->with('flash_success', 'Comment added successfully');
    }

    public function getDeleteComment($comment_id)
    {
        $comment = $this->comments->get($comment_id);
        if ($comment->author === $this->current_user->cid || $this->current_user->inGroup(\Sentry::findGroupByName('Executive'))) {
            $this->comments->delete($comment_id);
        }

        return \Redirect::back()->with('flash_success', 'Comment deleted successfully');
    }

    public function getEditComment($comment_id)
    {
        $this->setData('comment', $this->comments->get($comment_id));
        return $this->view('staff.roster.edit_comment');
    }

    public function postEditComment($comment_id)
    {
        if ($cid = $this->comments->updateRosterComment($comment_id, $this->request->all())) {
            $this->setFlash(['flash_success' => 'Comment edited successfully']);
            return \Redirect::to("/staff/{$cid}/edit");
        } else {
            $this->setFlash(['flash_error' => 'There was an error']);
            return $this->redirectBack();
        }
    }

    public function postGroup()
    {
        $input = $this->request->all();
        if ($this->groups->create($input)) {
            return \Redirect::route('roster')->with('flash_success', 'Group created successfully');
        } else {
            return \Redirect::back()->with('flash_error', 'Error creating group')->withInput();
        }

    }

    public function updateGroup()
    {
        if ($this->groups->updateGroup($this->request->all())) {
            return \Redirect::back()->with('flash_success', 'Group updated');
        } else {
            return \Redirect::back()->with('flash_error', 'Unable to update group');
        }
    }

    public function postVisitorDeny()
    {
        $staff = \Sentry::getUser();
        if ($results = $this->visitors->deny($staff, $this->request->all())) {
            Queue::push('Zbw\Queues\QueueDispatcher@usersDenyVisitor', $results);

            return \Redirect::back()->with('flash_success', 'Visitor request denied');
        } else {
            return \Redirect::back()->with('flash_error', $this->visitors->getErrors());
        }
    }

    public function postVisitorLor()
    {
        $staff = \Sentry::getUser();
        if ($this->visitors->addLor($staff, $this->request->all())) {
            return \Redirect::back()->with('flash_success', 'LOR uploaded successfully');
        } else {
            return \Redirect::back()->with('flash_error', $this->visitors->getErrors());
        }
    }

    public function postVisitorComment()
    {
        $staff = \Sentry::getUser();
        if ($comment = $this->visitors->comment($staff, $this->request->all())) {
            return \Redirect::back()->with('flash_success', 'Comment added successfully');
        } else {
            return \Redirect::back()->with('flash_error', $this->visitors->getErrors());
        }
    }

    public function postVisitorDelete($id)
    {
        if ($this->visitors->delete($id)) {
            return \Redirect::back()->with('flash_success', 'Applicant deleted successfully');
        } else {
            return \Redirect::back()->with('flash_error', 'Error deleting applicant');
        }
    }
}
