<?php

use Zbw\Cms\MessagesRepository;
use Zbw\Users\UserRepository;

class MessagesController extends BaseController
{

    private $users;
    private $messages;

    public function __construct(
      UserRepository $users,
      MessagesRepository $messages
    ) {
        $this->users = $users;
        $this->messages = $messages;
    }

    public function index()
    {
        $data = [
          'view'   => \Input::get('v'),
          'to' => \Input::get('to'),
          //'messages' => $this->messages->all($cid),
          'inbox'  => $this->messages->to(
            \Sentry::getUser()->cid,
            Input::get('unread')
          ),
          'outbox' => $this->messages->from(\Sentry::getUser()->cid),
          'trash'  => $this->messages->trashed(\Sentry::getUser()->cid),
          'unread' => Input::get('unread'),
          'users'  => $this->users->allVitals()
        ];

        return View::make('users.messages.index', $data);
    }

    public function outbox()
    {
        $data = [

        ];
        return View::make('users.messages.outbox', $data);
    }

    public function trash()
    {
        $data = [
        ];
        return View::make('users.messages.trash', $data);
    }

    /**
     *
     * @param integer cid
     * @param integer message id
     *
     * @return View
     */
    public function view($message_id)
    {
        $this->messages->markRead($message_id);
        $data = [
          'message' => $this->messages->withUsers($message_id),
          'users'   => $this->users->allVitals(),
        ];
        return View::make('users.messages.view', $data);
    }

    public function create()
    {
        $data = [

        ];
        return View::make('users.messages.create', $data);
    }

    public function store()
    {
        $input = \Input::all();
        $ret = $this->messages->add($input);
        if ($ret === '') {
            return Redirect::home()->with(
              'flash_success',
              'Message sent successfully'
            );
        } else {
            return Redirect::home()->with('flash_error', $ret);
        }
    }

    public function reply($mid)
    {
        $input = Input::all();
        if ($input['cc'] !== '') {
            $this->messages->cc($input, $input['cc'], $mid);
        }

        if ($this->messages->reply($input, $mid)) {
            return Redirect::home()->with(
              'flash_success',
              'Message sent successfully'
            );
        }
    }

    public function delete($message_id)
    {
        if ($this->messages->delete($message_id)) {
            return Redirect::route('messages')->with(
              'flash_success',
              'Message deleted successfully'
            );
        }
    }

    public function restore($message_id)
    {
        if ($this->messages->restore($message_id)) {
            return Redirect::route('messages')->with(
              'flash_success',
              'Message restored successfully'
            );
        }
    }
} 
