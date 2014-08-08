<?php  namespace Zbw\Bostonjohn;

use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Base\Helpers;

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

    public function newUserEmail($cid)
    {
        $user = $this->users->get($cid);
        $vData = [
            'user' => $user
        ];
        \Mail::send('zbw.emails.new-user', $vData, function($message) use ($user)
        {
            $message->from($this->from, $this->fromName);
            $message->to($user->email, $user->first_name . ' ' . $user->last_name);
            $message->subject('Welcome to vZBW');
        });
    }

    public function staffWelcomeEmail()
    {
        $vData = [
            'user' => $this->user
        ];
        \Mail::send('zbw.emails.welcome-staff', $vData, function($message)
        {
            $message->to($this->to, $this->user->first_name . ' ' . $this->user->last_name);
            $message->subject('Welcome to the ZBW Staff');
        });
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

    public function trainingRequestAcceptedEmail($data)
    {
        $vData = [
          'to' => $this->users->get($data['to']),
          'request' => $data['request'],
          'staff' => $this->users->get($data['request']->sid),
          'cert' => Helpers::readableCert($data['request']->cert_id),
          'start' => $data['request']->start->toDayDateTimeString(),
          'end' => $data['request']->end->toDayDateTimeString()
        ];
        $mData = [
          'to' => $vData['to']
        ];
        \Mail::send('zbw.emails.training_request_accepted', $vData, function($message) use ($mData) {
              $message->to($mData['to']->email, $mData['to']->first_name . ' ' . $mData['to']->last_name);
              $message->subject('ZBW Training Request');
          });
    }

    public function trainingRequestDroppedEmail($data)
    {
        $vData = [
          'to' => $this->users->get($data['to']),
          'request' => $data['request'],
          'cert' => Helpers::readableCert($data['request']->cert_id),
          'start' => $data['request']->start->toDayDateTimeString(),
          'end' => $data['request']->end->toDayDateTimeString()
        ];
        $mData = [
          'to' => $vData['to']
        ];
        \Mail::send('zbw.emails.training_request_dropped', $vData, function($message) use ($mData) {
              $message->to($mData['to']->email, $mData['to']->first_name . ' ' . $mData['to']->last_name);
              $message->subject('ZBW Training Request');
          });
    }

    public function visitorRequestEmail($data)
    {
        $to = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('DATM'));
        $vData = [
            'to' => $to[0],
            'firstname' => $data['fname'],
            'lastname' => $data['lname'],
            'rating' => $data['rating'],
            'home' => $data['home'],
            'email' => $data['email'],
            'body' => $data['editor'],
            'cid' => $data['cid']
        ];

        $mData = [
            'to' => $to[0]
        ];
        \Mail::send('zbw.emails.visitor_request', $vData, function($message) use ($mData) {
              $message->to($mData['to']->email, $mData['to']->first_name . ' ' . $mData['to']->last_name);
              $message->subject('ZBW Visiting Controller Request');
          });
    }
} 
