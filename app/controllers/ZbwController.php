<?php

use Zbw\Bostonjohn\Notifier;
use Zbw\Cms\Contracts\NewsRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

class ZbwController extends BaseController
{

    private $news;
    private $users;
    private $notifier;
    private $visitors;

    public function __construct(NewsRepositoryInterface $news, UserRepositoryInterface $users, Notifier $notifier, VisitorApplicantRepositoryInterface $visitors)
    {
        $this->news = $news;
        $this->users = $users;
        $this->notifier = $notifier;
        $this->visitors = $visitors;
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
            'to' => \Config::get('app.webmaster.email'),
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
          'to' => \Config::get('app.webmaster.email'),
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

    public function getVisit()
    {
        return View::make('zbw.visit');
    }

    public function postVisit()
    {
        $this->notifier->visitorRequestEmail(\Input::all());
        $this->visitors->create(\Input::all());
        return Redirect::home()->with('flash_success', 'Your request has been sent. We will be in contact as soon as possible.');
    }

    public function getJoin()
    {
        return View::make('zbw.join');
    }

    public function postContact()
    {
        Queue::push('Zbw\Bostonjohn\QueueDispatcher@contactStaffPublic', \Input::all());
        return Redirect::back()->with('flash_success', 'Your message has been sent successfully. We\'ll be in touch!');
    }

}
