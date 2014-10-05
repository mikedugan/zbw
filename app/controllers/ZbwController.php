<?php

use Illuminate\Session\Store;
use Zbw\Notifier\Mail;
use Zbw\Cms\Contracts\NewsRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

class ZbwController extends BaseController
{

    private $news;
    private $users;
    private $notifier;
    private $visitors;

    public function __construct(NewsRepositoryInterface $news, UserRepositoryInterface $users, Mail $notifier, VisitorApplicantRepositoryInterface $visitors, Store $session)
    {
        $this->news = $news;
        $this->users = $users;
        $this->notifier = $notifier;
        $this->visitors = $visitors;
        parent::__construct($session);
    }
    public function getIndex()
    {
        $metars = App::make('Zbw\Core\Repositories\MetarRepository');

        $this->setData('news', $this->news->front(5));
        $this->setData('metars', $metars->frontPage());
        $this->setData('atcs', \Staffing::frontPage());
        $this->setData('flights', \ZbwFlight::frontPage(5));
        $this->setData('inbounds', \ZbwFlight::countInbound());
        $this->setData('outbounds', \ZbwFlight::countOutbound());
        $this->setData('positions', \Staffing::positionsOnline());
        $this->setData('schedules', \Schedule::nextDay());
        $this->view('zbw');
    }

    public function getControllerIndex()
    {
        $this->view('zbw.controllers');
    }

    public function getPilotIndex()
    {
        $this->view('zbw.pilots');
    }

    public function postFeedback()
    {
        $input = \Input::all();
        if(!empty($input['poobear'])) { return Redirect::home(); }
        $data = [
            'to' => \Config::get('app.webmaster.email'),
            'from' => $input['email'],
            'subject' => $input['subject'],
            'content' => $input['content'],
        ];

        \Mail::send('zbw.emails.feedback', $data, function($message) use ($data) {
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

        \Mail::send('zbw.emails.error', $data, function($message) use ($data) {
              $message->to($data['to'])->subject('ZBW Error Report');
          });
        return Redirect::back()->with('flash_success', 'Feedback sent successfully');
    }

    public function getVisit()
    {
        $this->view('zbw.visit');
    }

    public function postVisit()
    {
        $this->notifier->visitorRequestEmail(\Input::all());
        $this->visitors->create(\Input::all());
        return Redirect::home()->with('flash_success', 'Your request has been sent. We will be in contact as soon as possible.');
    }

    public function getJoin()
    {
        $this->view('zbw.join');
    }

    public function postContact()
    {
        Queue::push('Zbw\Queues\QueueDispatcher@contactStaffPublic', \Input::all());
        return Redirect::back()->with('flash_success', 'Your message has been sent successfully. We\'ll be in touch!');
    }

    public function getStatistics()
    {
        $engine = App::make('Zbw\Core\StatisticsEngine');
        $this->setData('this_month', $engine->month(10));
        $this->setData('last_month', $engine->lastMonth(10));
        $this->setData('center', $engine->center(10));
        $this->setData('tracon', $engine->tracon(10));
        $this->setData('ground', $engine->ground(10));
        $this->setData('overall', $engine->overall(10));
        $this->setData('tower', $engine->tower(10));
        $this->setData('positions', $engine->positions(10));
        $this->view('zbw.statistics');
    }

    public function getFlights()
    {
        $this->setData('flights', \ZbwFlight::all());
        return $this->view('zbw.traffic');
    }

}
