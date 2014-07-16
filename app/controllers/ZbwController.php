<?php

use Zbw\Cms\Contracts\NewsRepositoryInterface;

class ZbwController extends BaseController
{

    private $news;

    public function __construct(NewsRepositoryInterface $news)
    {
        $this->news = $news;
    }
    public function getIndex()
    {
        $data = [
          'title'   => 'vZBW ARTCC',
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
          'title' => 'vZBW Controller Home'
        ];
        return View::make('zbw.controllers', $data);
    }

    public function getPilotIndex()
    {
        $data = [
          'title' => 'vZBW Pilot Home'
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
