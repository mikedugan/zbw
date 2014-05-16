<?php

use Zbw\Repositories\MessagesRepository;

class MessengerController extends BaseController {
    public function index()
    {
        $data = [
            //'messages' => MessagesRepository::all($cid),
            'inbox' => MessagesRepository::to(Auth::user()->cid, Input::get('unread')),
            'unread' => Input::get('unread')
        ];

        return View::make('users.messages.inbox', $data);
    }

    /**
     *
     * @param integer cid
     * @param integer message id
     * @return View
     */
    public function view($message_id)
    {
        MessagesRepository::markRead($message_id);
        $data = [
            'message' => MessagesRepository::withUsers($message_id),
            'users' => \Zbw\Repositories\UserRepository::allVitals(),
        ];
        return View::make('users.messages.view', $data);
    }

    public function create()
    {
        $data = [
            'users' => \Zbw\Repositories\UserRepository::allVitals()
        ];
        return View::make('users.messages.create', $data);
    }

    public function store()
    {
        $input = \Input::all();
        $ret = MessagesRepository::add($input);
        if($ret === '')
        {
            return Redirect::home()->with('flash_success', 'Message sent successfully');
        }
        else
        {
            return Redirect::home()->with('flash_error', $ret);
        }
    }

    public function reply($mid)
    {
        $input = Input::all();
        if($input['cc'] !== '')
        {
            MessagesRepository::cc($input, $input['cc'], $mid);
        }

        if(MessagesRepository::reply($input, $mid))
        {
            return Redirect::home()->with('flash_success', 'Message sent successfully');
        }
    }

    public function delete($message_id)
    {
        if(MessagesRepository::delete($message_id))
        {
            return Redirect::route('inbox')->with('flash_success', 'Message deleted successfully');
        }
    }
} 
