<?php namespace Tests\Staff;

use \AcceptanceTester;

class SuperadminIsAvailableCest
{
    public function staffCantSeeSuperAdmin(AcceptanceTester $I)
    {
        \Sentry::login(\User::find(1088911));
        $I->am('a mentor');
        $I->wantTo('try to access superadmin');
        $I->amOnPage('/');
        $I->seeLink('Staff');
        $I->dontSeeLink('Admin');
    }

    public function adminCanSeeSuperAdmin(AcceptanceTester $I)
    {
        \Sentry::login(\User::find(1240047));
        $I->am('a mentor');
        $I->wantTo('try to access superadmin');
        $I->amOnPage('/');
        $I->seeLink('Staff');
        $I->dontSeeLink('Admin');
    }
}
