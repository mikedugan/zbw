<?php namespace Zbw\Cms;

use Zbw\Core\EloquentRepository;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

/**
 * @package Zbw\Cms
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.b
 */
class MessagesRepository extends EloquentRepository implements MessagesRepositoryInterface
{

    const PRIVATE_MESSAGE = 1;
    const SESSION_COMMENT = 2;
    const EVENT_COMMENT = 3;
    const NEWS_COMMENT = 4;
    const EXAM_COMMENT = 5;
    /**
     * @var UserRepositoryInterface
     */
    private $users;
    /**
     * @var string
     */
    public $model = '\Message';

    /**
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    /**
     * @param array   input
     * @param integer cid
     * @param integer origin message id
     * @return boolean
     */
    public function reply($input, $mid)
    {
        $m = new \Message;
        $m->subject = $input['subject'];
        $m->content = $input['content'];
        $m->to = $input['to'];
        $m->cid = $input['to'];
        $m->from = isset($input['from']) ? $input['from'] : \Sentry::getUser()->cid;
        $m->history = $input['history'];

        $mm = new \Message;
        $mm->subject = $input['subject'];
        $mm->content = $input['content'];
        $mm->to = $input['to'];
        $mm->cid = isset($input['from']) ? $input['from'] : \Sentry::getUser()->cid;
        $mm->from = isset($input['from']) ? $input['from'] : \Sentry::getUser()->cid;
        $mm->history = $input['history'];

        if (isset($input['forget_history']) && $input['forget_history'] === 'forget') {
            $m->history = '';
        }

        $errors = [' '];
        $success = true;
        if ( ! $this->checkAndSave($m)) {
            $errors = $this->getErrors();
            $success = false;
        }
        if ( ! $this->checkAndSave($mm)) {
            if (is_array($errors)) {
                $errors = array_merge($errors, $this->getErrors());
                $success = false;
            } else {
                $errors = $this->getErrors();
                $success = false;
            }
        }
        if ( ! $success) {
            return $errors;
        } else {
            \Queue::push('Zbw\Queues\QueueDispatcher@contactNewPm', $m);
            return true;
        }
    }

    /**
     * @param array   input
     * @param array   users being cc'd
     * @param integer cid of sender
     * @param integer message id
     * @return void
     */
    public function cc($input, $to, $mid)
    {
        $to = explode(',', str_replace(' ', '', $to));
        foreach ($to as $user) {
            $input['to'] = $this->users->findByInitials($user)->cid;
            $input['from'] = \Sentry::getUser()->cid;
            $this->reply($input, $mid);
        }
    }

    /**
     * @static
     * @param null $cid
     * @return int
     */
    public static function newMessageCount($cid = null)
    {
        $cid = is_null($cid) ? \Sentry::getUser()->cid : $cid;

        return \Message::where('to', $cid)
                       ->where('cid', \Sentry::getUser()->cid)
                       ->where('is_read', 0)->get(['id'])->count();
    }

    /**
     * @param array $input
     * @return mixed array|boolean
     */
    public function add($input)
    {
        $errors = '';
        $recipients = explode(',', str_replace(' ', '', $input['to']));
        if (count($recipients) == 1) {
            $this->create($recipients[0], $input['subject'], $input['message']);
        } else {
            foreach ($recipients as $r) {
                $errors .= $this->create($r, $input['subject'], $input['message']);
            }
        }

        return $errors;
    }

    /**
     * @param $to
     * @param $subject
     * @param $content
     * @internal param $input
     * @return bool|string
     */
    public function create($to, $subject, $content)
    {
        $from = \Sentry::check() ? \Sentry::getUser()->cid : 100;
        $to = $this->users->findByInitials($to)->cid;

        $outbox = $this->make();
        $outbox->to = $to;
        $outbox->subject = $subject;
        $outbox->content = $content;
        $outbox->from = $from;
        $outbox->cid = $from;
        $outbox->save();

        if ($from === $to) { return $this->checkAndSave($outbox); }

        $inbox = $this->make();
        $inbox->to = $to;
        $inbox->subject = $subject;
        $inbox->content = $content;
        $inbox->from = $from;
        $inbox->cid = $to;
        $inbox->save();
        \Queue::push('Zbw\Queues\QueueDispatcher@contactNewPm', $inbox);
        return ( ! $this->checkAndSave($outbox) || ! $this->checkAndSave($inbox)) ? $this->getErrors() : '';
    }

    /**
     * @param integer message id
     * @return PrivateMessage
     */
    public function withUsers($id)
    {
        return $this->make()->with(['sender', 'recipient'])->where('id', $id)
                    ->firstOrFail();
    }

    /**
     * @param integer message id
     * @return boolean
     * @deprecated
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
        foreach ($this->make()->where('to', \Sentry::getUser()->cid)->get() as $message) {
            $message->is_read = 1;
            $message->save();
        }

        return true;
    }

    /**
     * @return Eloquent Collection
     */
    public function trashed()
    {
        return $this->make()->onlyTrashed()->where(
          'to',
          \Sentry::getUser()->cid
        )->where('cid', \Sentry::getUser()->cid)->get();
    }

    /**
     * @param integer user cid
     * @param boolean unread messages only
     * @return Eloquent Collection
     */
    public function to($user, $unread = false)
    {
        $messages = $this->make()->where('to', $user)->where('cid', $user)
                         ->orderBy('created_at', 'DESC');

        return $unread ? $messages->where('is_read', 0)->get() : $messages->get();
    }

    /**
     * @param integer user cid
     * @return Eloquent Collection
     */
    public function from($user)
    {
        return $this->make()->where('from', $user)->where('cid', $user)
                    ->orderBy('created_at', 'DESC')->get();
    }

    /**
     * @param $input
     * @return void
     */
    public function update($input)
    {

    }
}
