<?php namespace Tests\Staff;

use \AcceptanceTester;

class SuperadminIsAvailableCest
{
    // tests
    public function staffCantSeeSuperAdmin(AcceptanceTester $I)
    {
        \Sentry::login(\User::find(1088911));
        $I->am('a mentor');
        $I->wantTo('try to access superadmin');
        $I->amOnPage('/roster');
        $I->canSeeLink('Staff');
        $I->cantSeeLink('Admin');

    }

    public function adminCanSeeSuperAdmin(AcceptanceTester $I)
    {
        \Sentry::login(\User::find(1240047));
        $I->am('a mentor');
        $I->wantTo('try to access superadmin');
        $I->amOnPage('/roster');
        $I->canSeeLink('Staff');
        $I->canSeeLink('Admin');

    }
}
