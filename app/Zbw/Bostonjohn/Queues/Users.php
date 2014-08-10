<?php  namespace Zbw\Bostonjohn\Queues;

use Illuminate\Queue\Jobs\Job;
use Zbw\Base\Helpers;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Bostonjohn\Notify\Mail;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

class Users {

    private $notifier;
    private $users;
    private $messages;

    public function __construct(Mail $notifier, UserRepositoryInterface $users, MessagesRepositoryInterface $messages)
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
        $user = \Sentry::findUserById($data);
        $user->activated = 1;
        $user->cert = 0;
        $user->save();
        $this->notifier->acceptVisitorEmail(\User::find($visitor->cid));
        $job->delete();
    }

    public function denyVisitor(Job $job, $data)
    {
        $this->notifier->denyVisitorEmail($data);
        $job->delete();
    }

    public function promote(Job $job, $data)
    {
        $user = $this->users->get($data);
        $user->cert = $user->cert + 1;
        $user->save();
        $vData = [
            'student' => $user,
            'cert' => Helpers::readableCert($user->cert)
        ];
        $messages = \App::make('Zbw\Cms\Contracts\MessagesRepositoryInterface');
        $message = \View::make('zbw.messages.controller_promotion', $vData)->render();
        $messages->create([
            'subject' => 'ZBW Promotion',
            'to' => $user->initials,
            'message' => str_replace('_USER_', $user->initials, $message)
        ]);

        $job->delete();
    }

    public function demote(Job $job, $data)
    {
        $user = $this->users->get($data);
        $user->cert = $user->cert - 1;
        $user->save();
        $vData = [
          'student' => $user,
          'cert' => Helpers::readableCert($user->cert)
        ];
        $messages = \App::make('Zbw\Cms\Contracts\MessagesRepositoryInterface');
        $message = \View::make('zbw.messages.controller_promotion', $vData)->render();
        $messages->create([
          'subject' => 'ZBW Promotion',
          'to' => $user->initials,
          'message' => str_replace('_USER_', $user->initials, $message)
        ]);

        $job->delete();
    }

    public function requestVatusaExam(Job $job, $data)
    {
        $this->notifier->vatusaExamRequestEmail($data);
        $student = \Sentry::findUserById($data);
        $exams = \App::make('Zbw\Training\Contracts\ExamsRepositoryInterface');
        $i = [
            'assigned_on' => \Carbon::now(),
            'cert_type_id' => $student->cert + 1,
            'total_questions' => 1,
            'cid' => $student->cid
        ];
        if($exam = $exams->create($i)) {
            $exam->correct = 1;
            $exam->wrong = 0;
            $exam->pass = 1;
            $exam->completed_on = \Carbon::now();
            $exam->save();
        }
        $job->delete();
    }

    public function adopt(Job $job, $data)
    {
        $this->notifier->adoptUserEmail($data['student'], $data['staff'], $data['subject'], $data['message'], $data['meeting']);
        $job->delete();
    }
} 
