<?php  namespace Zbw\Users\Handlers; 

use Zbw\Users\Commands\UpdateNotificationsCommand;
use Zbw\Users\Contracts\UserRepositoryInterface;

class UpdateNotificationsHandler
{
    /**
     *
     */
    private $users;

    public function __construct(UserRepositoryInterface $users)
    {

        $this->users = $users;
    }

    public function handle(UpdateNotificationsCommand $command)
    {
        $u = \Sentry::getUser();

        return $this->users->updateNotifications($u->cid, $command->getInput());
    }
} 
