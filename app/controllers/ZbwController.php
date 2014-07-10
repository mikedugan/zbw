<?php

use Zbw\Cms\NewsRepository;

class ZbwController extends BaseController
{

    private $news;

    public function __construct(NewsRepository $news)
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



}
