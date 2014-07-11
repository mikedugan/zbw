<?php

use Zbw\Poker\PokerService;

class PokerController extends \BaseController {

    private $service;

    public function __construct(PokerService $service)
    {
        $this->service = $service;
    }

    public function getIndex()
    {
        $data = [
            'pilots' => $this->service->getPilots()
        ];
        return View::make('staff.poker.index', $data);
    }

    public function postIndex()
    {
        $draw = $this->service->draw(\Input::all());
        return Redirect::back()->with('flash_success',
          $draw['card'] . " drawn for pilot " . $draw['pid']);
    }

    public function getPilot($pid)
    {
        $data = [
            'cards' => $this->service->getPilotCards($pid)
        ];
        return View::make('staff.poker.pilot', $data);
    }

    public function postDiscard($pid)
    {
        $this->service->discard(\Input::get('card'));
        return Redirect::back()->with('flash_success', 'Card discarded successfully');
    }
}
