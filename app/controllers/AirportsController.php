<?php

use Zbw\Airports\Airport;

class AirportsController extends BaseController
{
    private $airports;

    public function __construct(AirportRepository $airports, Session $store)
    {
        parent::__construct($store);
        $this->airports = $airports;
    }

    public function getIndex()
    {
        $airports = $this->airports->all();
        $this->setData('airports', $airports);
        return $this->view('zbw.airports.index');
    }

    public function getShow(Airport $airport)
    {
        $this->setData('airport', $airport);
        return $this->view('zbw.airports.show');
    }

    public function getEdit(Airport $airport)
    {
        $this->setData('airport', $airport);
        return $this->view('zbw.airports.edit');
    }

    public function postEdit()
    {
        $data = \Request::except('icao');
        $icao = \Request::get('icao');
        $response = $this->execute(UpdateAirportCommand::class, ['icao' => $icao, 'data' => $data]);
        $this->setFlash($response->getFlashData());
        return $this->redirectBack();
    }
}
