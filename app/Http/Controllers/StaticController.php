<?php namespace Zbw\Http\Controllers;

class StaticController extends BaseController
{
    public function getPilots()
    {
        return $this->view('static.pilots.index');
    }

    public function getPilotsGettingStarted()
    {
        return $this->view('static.pilots.getting_started');
    }

    public function getPilotsAirports()
    {
        return $this->view('static.pilots.airports');
    }

    public function getPilotsVfrTutorial()
    {
        return $this->view('static.pilots.tutorial_vfr');
    }

    /** Controller Pages */
    public function getControllersResources()
    {
        return $this->view('static.controllers.resources');
    }

    public function getControllersTrainingOutline()
    {
        return $this->view('static.controllers.training_outline');
    }

    public function getControllersSignonPolicy()
    {
        return $this->view('static.controllers.signon');
    }

    public function getControllersPositionRestrictions()
    {
        return $this->view('static.controllers.position_restrictions');
    }

    public function getControllersVisitingTransfer()
    {
        return $this->view('static.controllers.visiting_transfer');
    }

    public function getControllersRosterRemoval()
    {
        return $this->view('static.controllers.roster_removal');
    }

    public function getControllersPolicies()
    {
        return $this->view('static.controllers.policies');
    }

    public function getControllersBeaconCodes()
    {
        return $this->view('static.controllers.beacon_codes');
    }

    public function getTsDisplay()
    {
        return $this->view('static.controllers.teamspeak');
    }

    public function getDocumentLibrary()
    {
        return $this->view('static.controllers.documents');
    }
}
