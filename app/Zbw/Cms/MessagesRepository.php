<?php namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;
use Zbw\Facades\ZbwValidator;
use Zbw\Users\UserRepository;

class MessagesRepository extends EloquentRepository {
    const PRIVATE_MESSAGE = 1;
    const SESSION_COMMENT = 2;
    const EVENT_COMMENT = 3;
    const NEWS_COMMENT = 4;
    const EXAM_COMMENT = 5;
    private $users;
    public $model = '\Message';
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param array input
     * @param integer cid
     * @param integer origin message id
     * @return boolean
     */
    public function reply($input, $mid)
    {
        $invalid = ZbwValidator::get('Message', $input);
        if(is_array($invalid)) return $invalid;

        $m = $this->make()->create([
            'subject' => $input['subject'],
            'content' => $input['content'],
            'to' => $input['to'],
            'from' => \Auth::user()->cid,
            'history' => $input['history']
        ]);
        if(isset($input['forget_history']) && $input['forget_history'] === 'forget') { $m->history = '';}
        return $m->save();
    }

    /**
     * @param array input
     * @param array users being cc'd
     * @param integer cid of sender
     * @param integer message id
     * @return void
     */
    public function cc($input, $to, $mid)
    {
        $to = explode(',', str_replace(' ', '', $to));
        foreach($to as $user)
        {
            $input['to'] = $user;
            $input['from'] = \Auth::user()->cid;
            $this->reply($input, $mid);
        }
    }

    /**
     * @type static
     * @name newMessageCount
     * @description
     * @param null $cid
     * @return int
     */
    public static function newMessageCount($cid = null)
    {
        $cid = is_null($cid) ? Auth::user()->cid : $cid;
        return \Message::where('to', $cid)->where('is_read', 0)->get(['id'])->count();
    }

    /**
     * @param array $input
     * @return mixed array|boolean
     */
    public function add($input)
    {
        $errors = '';
        $recipients = explode(',', $input['to']);
        if(count($recipients) == 1) { return self::create($input); }
        else
        {
            foreach($recipients as $r)
            {
                $errors .= $this->create([
                    'to' => $r,
                    'subject' => $input['subject'],
                    'message' => $input['message']
                ]);
            }
        }
        return $errors;
    }

    public function create($input)
    {
        $message = new \Message([
            'to' => $this->users->findByInitials($input['to'])->cid,
            'subject' => $input['subject'],
            'content' => $input['message'],
            'from' => isset(\Auth::user()->cid) ? \Auth::user()->cid : 100
        ]);
        if( ! $message->save())
        {
            return 'Error sending to '.$input['to'];
        }
        else return '';
    }

    /**
     * @param integer message id
     * @return PrivateMessage
     */
    public function withUsers($id)
    {
        return $this->make()->with(['sender', 'recipient'])->where('id', $id)->firstOrFail();
    }

    /**
     * @param integer message id
     * @return boolean
     */
    public function markRead($mid)
    {
        $message = $this->make()->find($mid);
        $message->is_read = 1;
        return $message->save();
    }

    /**
     * @param integer cid
     * @return void
     */
    public function markAllRead()
    {
        foreach($this->make()->where('to', \Auth::user()->cid)->get() as $message)
        {
            $message->is_read = 1;
            $message->save();
        }

    }

    /**
     * @return Eloquent Collection
     */
    public function trashed()
    {
        return $this->make()->onlyTrashed()->where('to', \Auth::user()->cid)->get();
    }

    /**
     * @param integer user cid
     * @param boolean unread messages only
     * @return Eloquent Collection
     */
    public function to($user, $unread = false)
    {
        $messages = $this->make()->where('to', $user)->orderBy('created_at', 'DESC');
        return $unread ? $messages->where('is_read', 0)->get() : $messages->get();
    }

    /**
     * @param integer user cid
     * @return Eloquent Collection
     */
    public function from($user)
    {
        return $this->make()->where('from', $user)->orderBy('created_at', 'DESC')->get();
    }

    public function update($input)
    {

    }
}
