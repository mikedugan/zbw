<?php

class StaticController extends BaseController
{
    public function getPilots()
    {
        return View::make('static.pilots.index');
    }

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

    /** Controller Pages */
    public function getControllersTrainingOutline()
    {
        return View::make('static.controllers.training_outline');
    }

    public function getControllersSignonPolicy()
    {
        return View::make('static.controllers.signon');
    }

    public function getControllersPositionRestrictions()
    {
        return View::make('static.controllers.position_restrictions');
    }

    public function getControllersVisitingTransfer()
    {
        return View::make('static.controllers.visiting_transfer');
    }

    public function getControllersRosterRemoval()
    {
        return View::make('static.controllers.roster_removal');
    }

    public function getControllersPolicies()
    {
        return View::make('static.controllers.policies');
    }
}
