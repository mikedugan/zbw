<?php namespace Tests\Airports;
use \FunctionalTester;

class UpdateAirportCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function updateAirportAsExpected(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->see('ZBW');
        $I->seeCurrentUrlEquals('/');
    }
}
