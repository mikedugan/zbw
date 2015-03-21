<?php  namespace Zbw\Notifier;

use Zbw\Core\Helpers;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

/**
 * @package Bostonjohn
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.9b
 */
class Message extends Notifier {

    private $messages;
    private $users;

    /**
     * @param MessagesRepositoryInterface $messages
     * @param UserRepositoryInterface     $users
     */
    public function __construct(MessagesRepositoryInterface $messages, UserRepositoryInterface $users)
    {
        parent::__construct($users);
        $this->messages = $messages;
    }

    /**
     * Renders the array of data saved in the property to an actual view
     *
     * @return void
     */
    private function render()
    {
        $this->view_data = \View::make($this->view, $this->view_data);
    }

    /**
     * @param $to
     * @param $subject
     * @return void
     */
    private function send($to, $subject)
    {
        $this->render();
        $this->messages->create($to, $subject, $this->view_data);
    }

    /**
     * sends a promotion message
     *
     * @param $to
     * @return void
     */
    public function promotionMessage($to)
    {
        $to = $this->users->get($to);
        $this->setView('controller_promotion');
        $this->setViewData([
            'student' => $to,
            'cert' => Helpers::readableCert($to->cert)
        ]);
        $this->send($to, 'ZBW Promotion');

    }
} 
