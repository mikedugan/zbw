<?php  namespace Zbw\Queues;

use Illuminate\Queue\Jobs\Job;
use Zbw\Core\Helpers;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Notifier\Mail;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

/**
 * @package Zbw\Queues
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class Users {

    /**
     *  Mail
     */
    private $notifier;
    /**
     *  UserRepositoryInterface
     */
    private $users;
    /**
     *  MessagesRepositoryInterface
     */
    private $messages;

    /**
     * @param Mail                        $notifier
     * @param UserRepositoryInterface     $users
     * @param MessagesRepositoryInterface $messages
     */
    public function __construct(Mail $notifier, UserRepositoryInterface $users, MessagesRepositoryInterface $messages)
    {
        $this->notifier = $notifier;
        $this->users = $users;
        $this->messages = $messages;
    }

    public function staffWelcome(Job $job, $data)
    {
        $this->notifier->staffWelcomeEmail($data);

        $job->delete();
    }

    /**
     * @param Job $job
     * @param     $data
     * @return void
     */
    public function newUser(Job $job, $data)
    {
        $vdata = [
          'student' => $data
        ];
        //render the private message view
        $message = \View::make('zbw.messages.s_new_user', $vdata)->render();
        $users = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('Executive'));
        foreach($users as $user) {
            $this->messages->create($user->initials,'New ZBW Controller', str_replace('_USER_', $user->initials, $message));
        }

        $this->notifier->newUserEmail($data['cid']);

        $job->delete();
    }

    /**
     * @param Job $job
     * @param     $data
     * @return void
     */
    public function acceptVisitor(Job $job, $data)
    {
        $this->notifier->acceptVisitorEmail(\User::find($data));
        $job->delete();
    }

    /**
     * @param Job $job
     * @param     $data
     * @return void
     */
    public function denyVisitor(Job $job, $data)
    {
        $this->notifier->denyVisitorEmail($data);
        $job->delete();
    }

    /**
     * @param Job $job
     * @param     $data
     * @return void
     */
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
        $messages->create($user->initials, 'ZBW Promotion', str_replace('_USER_', $user->initials, $message));

        $job->delete();
    }

    /**
     * @param Job $job
     * @param     $data
     * @return void
     */
    public function demote(Job $job, $data)
    {
        $user = $this->users->get($data);
        $user->cert -= 1;
        $user->save();
        $vData = [
          'student' => $user,
          'cert' => Helpers::readableCert($user->cert)
        ];
        $messages = \App::make('Zbw\Cms\Contracts\MessagesRepositoryInterface');
        $message = \View::make('zbw.messages.controller_demotion', $vData)->render();
        $messages->create($user->initials, 'ZBW Demotion', str_replace('_USER_', $user->initials, $message));

        $job->delete();
    }

    /**
     * @param Job $job
     * @param     $data
     * @return void
     */
    public function requestVatusaExam(Job $job, $data)
    {
        $this->notifier->vatusaExamRequestEmail($data[0], $data[1]);
        /*$student = \Sentry::findUserById($data);
        $exams = \App::make('Zbw\Training\Contracts\ExamsRepositoryInterface');
        /*$i = [
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
        }*/
        $job->delete();
    }

    public function requestZbwExam(Job $job, $data)
    {
        $this->notifier->zbwExamRequestEmail($data[0], $data[1]);
        /*$student = \Sentry::findUserById($data);
        $exams = \App::make('Zbw\Training\Contracts\ExamsRepositoryInterface');
        /*$i = [
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
        }*/
        $job->delete();
    }

    /**
     * @param Job $job
     * @param     $data
     * @return void
     */
    public function adopt(Job $job, $data)
    {
        $this->notifier->adoptUserEmail($data['student'], $data['staff'], $data['subject'], $data['message'], $data['meeting']);
        $job->delete();
    }

    public function newForumAccount(Job $job, $data)
    {
        $this->notifier->newForumAccountEmail($data['user'], $data['password']);
        $job->delete();
    }
} 
