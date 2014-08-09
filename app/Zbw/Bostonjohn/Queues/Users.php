<?php  namespace Zbw\Bostonjohn\Queues;

use Illuminate\Queue\Jobs\Job;
use Zbw\Base\Helpers;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Bostonjohn\Notifier;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

class Users {

    private $notifier;
    private $users;
    private $messages;

    public function __construct(Notifier $notifier, UserRepositoryInterface $users, MessagesRepositoryInterface $messages)
    {
        $this->notifier = $notifier;
        $this->users = $users;
        $this->messages = $messages;
    }

    public function newUser(Job $job, $data)
    {
        $vdata = [
          'student' => $data
        ];
        //render the private message view
        $message = \View::make('zbw.messages.s_new_user', $vdata)->render();
        $users = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('Executive'));
        foreach($users as $user) {
            $this->messages->create([
              'subject' => 'New ZBW Controller',
              'to' => $user->initials,
              'message' => str_replace('_USER_', $user->initials, $message)
            ]);
        }

        $this->notifier->newUserEmail($data['cid']);

        $job->delete();
    }

    public function acceptVisitor(Job $job, $data)
    {
        $visitor = \VisitorApplicant::find($data);
        $this->users->add($visitor->first_name, $visitor->last_name, $visitor->email, $visitor->home, $visitor->cid, $visitor->rating);
        $this->notifier->acceptVisitorEmail(\User::find($visitor->cid));
        $job->delete();
    }

    public function denyVisitor(Job $job, $data)
    {
        $this->notifier->denyVisitorEmail($data);
        $job->delete();
    }
} 
