<?php

namespace Zbw\Http\Controllers;

use Illuminate\Session\Store;
use Redirect;
use View;
use Zbw\Http\Controllers\BaseController;
use Zbw\Poker\Contracts\PokerServiceInterface;
use Zbw\Poker\Exceptions\PilotNotFoundException;

class PokerController extends \Zbw\Http\Controllers\BaseController
{

    private $service;

    public function __construct(PokerServiceInterface $service, Store $session)
    {
        parent::__construct($session);
        $this->service = $service;
    }

    public function getIndex()
    {
        $data = [
            'pilots'    => $this->service->getPilots(),
            'standings' => $this->service->getStandings()
        ];
        return View::make('staff.poker.index', $data);
    }

    public function postIndex()
    {
        try {
            $draw = $this->service->draw(\Input::all());
        } catch (PilotNotFoundException $e) {
            return Redirect::back()->with('flash_error', 'Pilot not found!');
        }

        $pid = $this->request->get('pid');

        if ($draw) {
            $this->setFlash(['flash_success' => $draw['card'] . " drawn for pilot " . $pid]);
        } else {
            $this->setFlash(['flash_error' => "$pid must discard before they can draw a new card"]);
        }

        return $this->redirectBack();
    }

    public function getPilot($pid)
    {
        $data = [
            'pilot' => \PokerPilot::where('pid', $pid)->with(['cards'])->first()
        ];
        return View::make('staff.poker.pilot', $data);
    }

    public function postDiscard($pid)
    {
        $this->service->discard(\Input::get('card'));
        return \Redirect::back()->with('flash_success', 'Card discarded successfully');
    }

    public function postWipe()
    {
        if ($this->service->wipePilots() && $this->service->wipeCards()) {

            $this->setFlash(['flash_success' => 'Poker data successfully wiped out!']);
        } else {
            $this->setFlash(['flash_error' => 'Error removing poker data!']);
        }

        return $this->redirectBack();
    }
}
