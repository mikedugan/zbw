<?php

use Zbw\Cms\MessagesRepository;
use Zbw\Users\UserRepository;

class MessagesController extends BaseController {
    public function index()
    {
        $data = [
            'view' => \Input::get('v'),
            //'messages' => MessagesRepository::all($cid),
            'inbox' => MessagesRepository::to(Auth::user()->cid, Input::get('unread')),
            'outbox' => MessagesRepository::from(Auth::user()->cid),
            'trash' => MessagesRepository::trashed(Auth::user()->cid),
            'unread' => Input::get('unread'),
            'users' => UserRepository::allVitals()
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
     * @return View
     */
    public function view($message_id)
    {
        MessagesRepository::markRead($message_id);
        $data = [
            'message' => MessagesRepository::withUsers($message_id),
            'users' => UserRepository::allVitals(),
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
            return Redirect::route('me/messages')->with('flash_success', 'Message deleted successfully');
        }
    }
} 
