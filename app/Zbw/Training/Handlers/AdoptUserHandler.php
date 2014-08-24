<?php  namespace Zbw\Training\Handlers; 

use Zbw\Training\Commands\AdoptUserCommand;
use Zbw\Users\Contracts\UserRepositoryInterface;

class AdoptUserHandler
{
    private $users;

    /**
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {

        $this->users = $users;
    }

    public function handle(AdoptUserCommand $command)
    {
        if($this->users->adopt($command->cid, $command->sid)) {
            $input = ['student' => $command->cid, 'staff' => $command->sid, 'subject' => $command->subject, 'message' => $command->message, 'meeting' => $command->meeting];
            \Queue::push('Zbw\Bostonjohn\Queues\QueueDispatcher@usersAdopt', $input);
            return true;
        } else {
            return $this->users->getErrors();
        }
    }
} 
