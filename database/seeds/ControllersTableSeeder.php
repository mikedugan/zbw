<?php

class ControllersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->truncate();
        Eloquent::unguard();
        $faker = Faker\Factory::create();
        $parser = App::make('Zbw\Bostonjohn\Roster\RosterXmlParser');
        $parser->updateRoster();
        $migrator = App::make('Zbw\Bostonjohn\Roster\RosterJsonMigrator');
        $migrator->migrate();
    }

}
