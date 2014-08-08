<?php

class StaticController extends BaseController
{
    public function getPilotsGettingStarted()
    {
        return View::make('static.pilots.getting_started');
    }

    public function getPilotsAirports()
    {
        return View::make('static.pilots.airports');
    }

    public function getPilotsVfrTutorial()
    {
        return View::make('static.pilots.tutorial_vfr');
    }
}
