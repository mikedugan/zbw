<?php  namespace Zbw\Bostonjohn; 

class Emailer
{
    protected $to;
    protected $data;
    protected $fromName = 'vZBW ARTCC';
    protected $from = 'bostonjohn@bostonartcc.net';
    protected $user;
    public function __construct($user = null, $data = null)
    {
        $this->to = $user->email != null ? $user->email : null;
        $this->data = $data != null ? $data : null;
        $this->user = $user != null ? $user : null;
    }
    public function newUser()
    {
        $vData = [
            'user' => $this->user,
            'password' => $this->data['password']
        ];
        \Mail::send('zbw.emails.new-user', $vData, function($message)
        {
            $message->from($this->from, $this->fromName);
            $message->to($this->to, $this->user->first_name . ' ' . $this->user->last_name);
            $message->subject('Welcome to vZBW');
        });
    }
} 
