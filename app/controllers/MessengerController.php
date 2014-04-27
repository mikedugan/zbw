<?php

use Zbw\Repositories\MessagesRepository;

class MessengerController extends BaseController {
    public function index($cid)
    {
        $data = [
            //'messages' => MessagesRepository::all($cid),
            'inbox' => MessagesRepository::to($cid)
        ];

        return View::make('users.messages.inbox', $data);
    }

    /**
     *
     * @param integer cid
     * @param integer message id
     * @return View
     */
    public function view($cid, $message_id)
    {
        $data = [
            'message' => MessagesRepository::withUsers($message_id),
            'users' => \Zbw\Repositories\UserRepository::allVitals(),
        ];
        return View::make('users.messages.view', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Send Message'
        ];
        return View::make('users.messages.create');
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
