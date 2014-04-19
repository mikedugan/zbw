<?php

use Zbw\Repositories\MessagesRepository;

class MessengerController extends BaseController {
    public function index()
    {
        $data = [
            'messages' => '',
            'title' => 'Inbox'
        ];

        return View::make('user.messages.inbox', $data);
    }

    public function view($message_id)
    {
        $data = [
            'message' => MessagesRepository::find($message_id)
        ];
        return View::make('user.messages.show');
    }

    public function create()
    {
        $data = [
            'title' => 'Send Message'
        ];
        return View::make('user.messages.create');
    }

    public function store($user_id)
    {
        $input = \Input::all();
        $input['user_id'] = $user_id;
        if(MessagesRepository::add($input))
        {
            return Redirect::back()->with('flash_success', 'Message sent successfully');
        }
        else
        {
            return Redirect::back()->with('flash_error', 'Error sending message');
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
