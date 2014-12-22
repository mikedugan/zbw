<?php

use Zbw\Airports\Airport;
use Zbw\Airports\EloquentAirportRepository;
use Illuminate\Session\Store;

class AirportsController extends BaseController
{
    private $airports;

    public function __construct(EloquentAirportRepository $airports, Store $session)
    {
        parent::__construct($session);
        $this->airports = $airports;
    }

    public function getIndex()
    {
        switch(\Input::get('sort')) {
            case 'alpha':
                $airports = $this->airports->allAlphabetically();
                break;
            case 'tracon':
                $airports = $this->airports->allByTracon();
                break;
            case 'airspace':
            default:
                $airports = $this->airports->allByAirspace();
                break;

        }
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
