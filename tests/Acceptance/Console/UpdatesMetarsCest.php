<?php namespace Tests\Acceptance\Console;

use \AcceptanceTester;

class UpdatesMetarsCest
{
    public function updatesMetars(AcceptanceTester $I)
    {
        $I->am('cronjob');
        $I->wantTo('update the metars');
        $I->runShellCommand('php artisan vatsim:metars');
        $I->seeInShellOutput('METARs updated successfully!');
        $I->seeInDatabase('metars', ['facility' => 'KBOS']);
    }
}
