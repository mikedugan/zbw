<?php

use Zbw\Cms\Contracts\NewsRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

class ZbwController extends BaseController
{

    private $news;
    private $users;

    public function __construct(NewsRepositoryInterface $news, UserRepositoryInterface $users)
    {
        $this->news = $news;
        $this->users = $users;
    }
    public function getIndex()
    {
        $data = [
          'me'      => Auth::user(),
          'news'    => $this->news->front(5),
          'metars'  => \Metar::frontPage(),
          'atcs'    => \Staffing::frontPage(),
          'flights' => \ZbwFlight::frontPage(5)
        ];
        return View::make('zbw', $data);

    }

    public function getControllerIndex()
    {
        $data = [
        ];
        return View::make('zbw.controllers', $data);
    }

    public function getPilotIndex()
    {
        $data = [
        ];
        return View::make('zbw.pilots', $data);
    }

    public function postFeedback()
    {
        $input = \Input::all();
        if(!empty($input['poobear'])) { return Redirect::home(); }
        $data = [
            'to' => 'mike@mjdugan.com',
            'from' => $input['email'],
            'subject' => $input['subject'],
            'content' => $input['content']
        ];

        Mail::send('zbw.emails.feedback', $data, function($message) use ($data) {
            $message->to($data['to'])->subject('ZBW Feedback');
        });
        return Redirect::back()->with('flash_success', 'Feedback sent successfully');
    }

    public function postError()
    {
        $input = \Input::all();
        if(!empty($input['poobear'])) { return Redirect::home(); }
        $data = [
          'to' => 'mike@mjdugan.com',
          'name' => $input['name'],
          'email' => $input['email'],
          'page' => $input['page'],
          'error' => $input['error'],
          'action' => $input['action']
        ];

        Mail::send('zbw.emails.error', $data, function($message) use ($data) {
              $message->to($data['to'])->subject('ZBW Error Report');
          });
        return Redirect::back()->with('flash_success', 'Feedback sent successfully');
    }

}
