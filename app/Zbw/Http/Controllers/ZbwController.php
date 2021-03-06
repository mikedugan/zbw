<?php

namespace Zbw\Http\Controllers;

use Queue;
use Zbw\Http\Controllers\BaseController;
use Zbw\Notifier\Mail;
use Zbw\Cms\Contracts\NewsRepositoryInterface;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

class ZbwController extends BaseController
{
    public function getIndex()
    {
        $metars = \App::make('Zbw\Core\Repositories\MetarRepository');
        $news = \App::make(NewsRepositoryInterface::class);

        $this->setData('news', $news->front(5));
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
        return \Redirect::route('roster');
    }

    public function postFeedback()
    {
        $input = $this->request->all();
        if (! empty($input['poobear'])) {
            return \Redirect::home();
        }
        $data = [
            'to'       => 'mike@mjdugan.com',
            'from'     => $input['email'],
            'subject'  => $input['subject'],
            'content'  => $input['content'],
            'response' => isset($input['response']) ? 1 : 0
        ];

        \Mail::send('zbw.emails.feedback', $data, function ($message) use ($data) {
            $message->to($data['to'])->subject('ZBW Feedback');
        });
        return \Redirect::back()->with('flash_success', 'Feedback sent successfully');
    }

    public function postError()
    {
        $input = $this->request->all();
        if (! empty($input['poobear'])) {
            return \Redirect::home();
        }
        $data = [
            'to'     => \Config::get('app.webmaster.email'),
            'name'   => $input['name'],
            'email'  => $input['email'],
            'page'   => $input['page'],
            'error'  => $input['error'],
            'action' => $input['action']
        ];

        \Mail::send('zbw.emails.error', $data, function ($message) use ($data) {
            $message->to($data['to'])->subject('ZBW Error Report');
        });
        return \Redirect::back()->with('flash_success', 'Feedback sent successfully');
    }

    public function getVisit()
    {
        $this->view('zbw.visit');
    }

    public function postVisit()
    {
        $notifier = \App::make(Mail::class);
        $visitors = \App::make(VisitorApplicantRepositoryInterface::class);
        $notifier->visitorRequestEmail($this->request->all());
        $visitors->create($this->request->all());
        return \Redirect::home()->with('flash_success',
            'Your request has been sent. We will be in contact as soon as possible.');
    }

    public function getJoin()
    {
        $this->view('zbw.join');
    }

    public function postContact()
    {
        Queue::push('Zbw\Queues\QueueDispatcher@contactStaffPublic', $this->request->all());
        return \Redirect::back()->with('flash_success', 'Your message has been sent successfully. We\'ll be in touch!');
    }

    public function getStatistics()
    {
        $engine = \App::make('Zbw\Core\StatisticsEngine');
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
