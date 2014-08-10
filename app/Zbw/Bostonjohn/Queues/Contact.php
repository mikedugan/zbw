<?php  namespace Zbw\Bostonjohn\Queues;

use Illuminate\Queue\Jobs\Job;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Bostonjohn\Notify\Mail;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

/**
 * @package Bostonjohn
 * @author Mike Dugan <mike@mjdugan.com>
 * @since 2.0.8b
 */
class Contact {

    /**
     * @var \Zbw\Users\UserRepositoryInterface
     */
    private $users;
    /**
     * @var \Zbw\Bostonjohn\Notify\Mail
     */
    private $notifier;
    /**
     * @var \Zbw\Cms\MessagesRepository
     */
    private $messages;

    /**
     * @param UserRepositoryInterface     $users
     * @param \Zbw\Bostonjohn\Notify\Mail                    $notifier
     * @param MessagesRepositoryInterface $messages
     */
    public function __construct(UserRepositoryInterface $users, Mail $notifier, MessagesRepositoryInterface $messages)
    {
        $this->users = $users;
        $this->notifier = $notifier;
        $this->messages = $messages;
    }

    /**
     *  sends staff contact emails from the website
     * @param Job $job
     * @param     $data
     * @return void
     */
    public function staffPublic(Job $job, $data)
    {
        $this->notifier->staffContactEmail($data);
        $job->delete();
    }
} 
