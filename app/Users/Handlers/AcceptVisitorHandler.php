<?php  namespace Zbw\Users\Handlers; 

use Zbw\Users\Commands\AcceptVisitorCommand;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

class AcceptVisitorHandler
{
    /**
     * @var \Zbw\Users\VisitorApplicantRepository
     */
    private $visitors;
    private $users;

    function __construct(VisitorApplicantRepositoryInterface $visitors, UserRepositoryInterface $users)
    {
        $this->visitors = $visitors;
        $this->users = $users;
    }

    public function handle(AcceptVisitorCommand $command)
    {
        $cid = $this->visitors->accept($command->sid, $command->cid);
        if($cid) {
            $visitor = \VisitorApplicant::where('cid', $cid)->firstOrFail();
            $this->users->add($visitor->first_name, $visitor->last_name, $visitor->email, $visitor->home, $visitor->cid, $visitor->rating);
            $user = $this->users->get($cid);
            $user->activated = 1;
            $user->guest = 0;
            $user->cert = 0;
            $user->save();
            Queue::push('Zbw\Queues\QueueDispatcher@usersAcceptVisitor', $cid);
            return true;
        } else {
            return $this->visitors->getErrors();
        }
    }
} 
