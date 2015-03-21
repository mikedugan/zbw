<?php namespace Tests\Staff;

use \AcceptanceTester;

class StaffMenuIsAvailableCest
{
    public function staffMenuNotAvailableToGuest(AcceptanceTester $I)
    {
        $I->am('a guest');
        $I->wantTo('try to get into staff');
        $I->amOnPage('/');
        $I->cantSeeLink('Staff');
    }

    public function staffMenuAvailableToStaff(AcceptanceTester $I)
    {
        \Sentry::login(\User::find(1240047));
        $I->am('a staff member');
        $I->wantTo('access the staff area');
        $I->amOnPage('/');
        $I->seeLink('Staff');
    }
}
