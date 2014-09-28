<?php

class StaticController extends BaseController
{
    public function getPilots()
    {
        $this->view('static.pilots.index');
    }

    public function getPilotsGettingStarted()
    {
        $this->view('static.pilots.getting_started');
    }

    public function getPilotsAirports()
    {
        $this->view('static.pilots.airports');
    }

    public function getPilotsVfrTutorial()
    {
        $this->view('static.pilots.tutorial_vfr');
    }

    /** Controller Pages */
    public function getControllersResources()
    {
        $this->view('static.controllers.resources');
    }

    public function getControllersTrainingOutline()
    {
        $this->view('static.controllers.training_outline');
    }

    public function getControllersSignonPolicy()
    {
        $this->view('static.controllers.signon');
    }

    public function getControllersPositionRestrictions()
    {
        $this->view('static.controllers.position_restrictions');
    }

    public function getControllersVisitingTransfer()
    {
        $this->view('static.controllers.visiting_transfer');
    }

    public function getControllersRosterRemoval()
    {
        $this->view('static.controllers.roster_removal');
    }

    public function getControllersPolicies()
    {
        $this->view('static.controllers.policies');
    }

    public function getTsDisplay()
    {
        $this->view('static.controllers.teamspeak');
    }
}
