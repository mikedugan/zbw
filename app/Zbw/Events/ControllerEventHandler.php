<?php  namespace Zbw\Events;

/**
 * @package Events
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class ControllerEventHandler {

    /**
     * @var \Zbw\Bostonjohn\Notify\Mail
     */
    private $emailer;

    /**
     *
     */
    public function __construct()
    {
        $this->emailer = \App::make('Zbw\Bostonjohn\Notify\Mail');
    }

    /**
     * @param $events
     * @return void
     */
    public function subscribe($events)
    {
        $list = [
        'controller.welcomeNew',
        'controller.welcomeMentor',
        'controller.welcomeStaff',
        'controller.suspend',
        'controller.terminate',
        'controller.newTrainingRequest'
        ];

        foreach($list as $event) {
            $method = 'Zbw\Events\ControllerEventHandler@'.explode('.', $event)[1];
            $events->listen($event, $method);
        }
    }

    /**
     * @param \User $user
     * @return void
     */
    public function welcomeNew(\User $user)
    {
        $this->emailer->newUser($user);
    }

    /**
     * @param $event
     * @return void
     */
    public function welcomeMentor($event)
    {

    }

    /**
     * @param $event
     * @return void
     */
    public function welcomeStaff($event)
    {

    }

    /**
     * @param $event
     * @return void
     */
    public function suspend($event)
    {

    }

    /**
     * @param $event
     * @return void
     */
    public function terminate($event)
    {

    }

    /**
     * @param $tr
     * @return void
     */
    public function newTrainingRequest($tr)
    {
        $this->emailer->newTrainingRequestMessage($tr);
    }
} 
