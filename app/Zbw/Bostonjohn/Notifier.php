<?php  namespace Zbw\Bostonjohn;

use Zbw\Cms\MessagesRepository;

class Notifier
{
    protected $to;
    protected $data;
    protected $fromName = 'vZBW ARTCC';
    protected $from = 'bostonjohn@bostonartcc.net';
    protected $user;
    protected $log;
    private $messages;
    public function __construct(MessagesRepository $messages)
    {
        $this->messages = $messages;
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

    public function newTrainingRequestMessage(\TrainingRequest $request)
    {
        $recipients = \User::where('rating_id', '>=', $request->student->rating_id)->where('is_mentor', true)->orWhere('is_instructor', true)->get();
        $content = $request->student->initials . ' has requested training on ' . $request->certType->value . '. Please visit ' . \HTML::link('training/request'.$request->id) . ' to view the request.'.
        "\r\nThis is an automated message from Boston John. Please do not reply.";
        foreach($recipients as $recipient) {
            if($recipient->initials) {
                $this->messages->create(
                  [
                    'to'      => $recipient->initials,
                    'subject' => 'New Training Request',
                    'message' => $content
                  ]
                );
            }
        }
        return $recipients;
    }
} 
