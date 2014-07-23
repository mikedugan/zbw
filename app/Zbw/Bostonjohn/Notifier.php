<?php  namespace Zbw\Bostonjohn;

use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

class Notifier
{
    protected $to;
    protected $data;
    protected $fromName = 'vZBW ARTCC';
    protected $from = 'bostonjohn@bostonartcc.net';
    protected $user;
    protected $log;
    private $messages;
    public function __construct(MessagesRepositoryInterface $messages, UserRepositoryInterface $users)
    {
        $this->messages = $messages;
        $this->users = $users;
        $this->log = new ZbwLog();
    }

    public function newUserEmail(\User $user)
    {
        $vData = [
            'user' => $user,
            'password' => 'foobar'
        ];
        \Mail::send('zbw.emails.new-user', $vData, function($message) use ($user)
        {
            $message->from($this->from, $this->fromName);
            $message->to($user->email, $user->first_name . ' ' . $user->last_name);
            $message->subject('Welcome to vZBW');
        });
        //$this->log->addLog('New user email sent to ' . $this->user->initials, '');
    }

    public function staffWelcomeEmail()
    {
        $vData = [
            'user' => $this->user
        ];
        \Mail::send('zbw.emails.welcome-staff', $vData, function($message)
        {
            $message->from($this->from, $this->fromName);
            $message->to($this->to, $this->user->first_name . ' ' . $this->user->last_name);
            $message->subject('Welcome to the ZBW Staff');
        });
        $log = new ZbwLog();
        $this->log->addLog('Staff welcome message sent to' . $this->user->initials, '');
    }

    public function trainingRequestEmail($data)
    {
        $vData = [
            'user' => $this->users->get($data['cid']),
            'to' => $this->users->get($data['to']),
            'request' => $data['request']
        ];
        $mData = [
            'to' => $vData['to']
        ];
        \Mail::send('zbw.emails.training-request', $vData, function($message) use ($mData) {
              $message->to($mData['to']->email, $mData['to']->first_name . ' ' . $mData['to']->last_name);
              $message->subject('ZBW Training Request');
          });
    }
} 
