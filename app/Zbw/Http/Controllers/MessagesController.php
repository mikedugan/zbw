<?php namespace Zbw\Http\Controllers;

use Illuminate\Session\Store;
use Zbw\Cms\MessagesRepository;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Cms\Commands\SendMessageCommand;
use Zbw\Cms\Commands\ReplyToMessageCommand;

class MessagesController extends BaseController
{

    private $users;
    private $messages;

    public function __construct(UserRepositoryInterface $users, MessagesRepository $messages, Store $store)
    {
        parent::__construct($store);
        $this->users = $users;
        $this->messages = $messages;
    }

    public function index()
    {
        $view = $this->request->get('v');
        $this->setData('view', $view);
        $this->setData('unread', $this->request->get('unread'));
        $this->setData('to', $this->request->get('to'));
        $this->setData('users', $this->users->allVitals());
        switch ($view) {
            case '':
            case 'inbox':
            case null:
                $this->setData('inbox', $this->messages->to(\Sentry::getUser()->cid, $this->request->get('unread')));
                break;
            case 'outbox':
                $this->setData('outbox', $this->messages->from(\Sentry::getUser()->cid));
                break;
            case 'trash':
                $this->setData('trash', $this->messages->trashed(\Sentry::getUser()->cid));
                break;
        }

        $this->view('users.messages.index');
    }

    public function postAction()
    {
        $selected = $this->request->get('selected');
        $action = $this->request->get('action');
        switch ($action) {
            case 'delete':
                $this->messages->deleteMany($selected);
                break;
            case 'read':
                $this->messages->markManyRead($selected);
                break;
        }

        return $this->redirectBack();
    }

    public function outbox()
    {
        $this->view('users.messages.outbox');
    }

    public function trash()
    {
        $this->view('users.messages.trash');
    }

    /**
     *
     * @param integer cid
     * @param integer message id
     *
     * @return View
     */
    public function viewMessage($message_id)
    {
        $message = $this->messages->get($message_id);
        $message->markRead();
        $this->setData('view', '');
        $this->setData('message', $message);
        $this->setData('users', $this->users->allVitals());
        $this->view('users.messages.view');
    }

    public function create()
    {
        $this->view('users.messages.create');
    }

    public function store()
    {
        $response = $this->execute(SendMessageCommand::class, ['input' => $this->request->all()]);
        if ($response !== '') {
            $this->setFlash(['flash_error' => $response]);
        } else {
            $this->setFlash(['flash_success' => 'Message sent successfully']);
        }

        return $this->redirectHome();
    }

    public function reply($mid)
    {
        $input = Input::all();
        $response = $this->execute(ReplyToMessageCommand::class, ['message_id' => $mid, 'input' => $input]);
        if ($response instanceof Illuminate\Support\MessageBag) {
            $this->setFlash(['flash_error' => $response]);
            return $this->redirectBack()->withInput();
        }

        $this->setFlash(['flash_success' => 'Reply sent successfully']);
        return $this->redirectRoute('messages');
    }

    public function delete($message_id)
    {
        if ($this->messages->delete($message_id)) {
            $this->setFlash(['flash_success' => 'Message deleted successfully']);
            return $this->redirectRoute('messages');
        }
    }

    public function restore($message_id)
    {
        if (! $this->messages->restore($message_id)) {
            $this->setFlash(['flash_error' => $this->messages->getErrors()]);
            return $this->redirectBack();
        } else {
            $this->setFlash(['flash_success' => 'Message restored successfully']);
            return $this->redirectRoute('messages');
        }
    }

    public function markAllRead()
    {
        $messages = $this->messages->getUnread($this->current_user->cid);
        foreach ($messages as $m) {
            $m->is_read = 1;
            $m->save();
        }
        return \Redirect::back()->with('flash_success', 'All messages marked read');
    }

    /**
     * @return string
     */
    public function aMarkInboxRead()
    {
        if ($this->messages->markAllRead(\Sentry::getUser()->cid)) {
            return $this->json(['success' => true, 'message' => 'All messaged marked as read']);
        } else {
            return $this->json(['success' => false, 'message' => 'Error marking messages read']);
        }
    }
}
