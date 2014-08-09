<?php  namespace Zbw\Bostonjohn\Queues;

use Illuminate\Queue\Jobs\Job;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Bostonjohn\Notifier;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

class Contact {

    private $users;
    private $notifier;
    private $messages;

    /**
     * @param UserRepositoryInterface     $users
     * @param Notifier                    $notifier
     * @param MessagesRepositoryInterface $messages
     */
    public function __construct(UserRepositoryInterface $users, Notifier $notifier, MessagesRepositoryInterface $messages)
    {
        $this->users = $users;
        $this->notifier = $notifier;
        $this->messages = $messages;
    }

    public function staffPublic(Job $job, $data)
    {
        $this->notifier->staffContactemail($data);
        $job->delete();
    }
} 
