<?php namespace Tests\Staff;

use \AcceptanceTester;

class StaffMenuIsAvailableCest
{
    // tests
    public function staffMenuNotAvailableToGuest(AcceptanceTester $I)
    {
        $I->am('a guest');
        $I->wantTo('try to get into staff');
        $I->amOnPage('/');
        $I->cantSeeLink('Staff');

        \Sentry::login(\User::find(1240047));
        $I->am('a staff member');
        $I->amOnPage('/');
        $I->canSeeLink('Staff');
        $I->canSeeLink('Pages');
    }
}
