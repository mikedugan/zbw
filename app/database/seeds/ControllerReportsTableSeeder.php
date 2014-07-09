<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ControllerReportsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        DB::table('controller_training_reports')->truncate();
        $lev = ['0', '5', '10', '-1'];
        $ots = ['-1', '0', '1'];
        foreach(range(1, 150) as $index)
        {
            $r = new TrainingReport();
            $r->training_session_id = $index;
            $r->brief = $faker->randomElement($lev);
            $r->runway = $faker->randomElement($lev);
            $r->weather = $faker->randomElement($lev);
            $r->coordination = $faker->randomElement($lev);
            $r->flow = $faker->randomElement($lev);
            $r->identity = $faker->randomElement($lev);
            $r->separation = $faker->randomElement($lev);
            $r->pointouts = $faker->randomElement($lev);
            $r->loa = $faker->randomElement($lev);
            $r->airspace = $faker->randomElement($lev);
            $r->phraseology = $faker->randomElement($lev);
            $r->priority = $faker->randomElement($lev);
            $r->markups = $faker->sentence();
            $r->markdown = $faker->sentence();
            $r->reviewed = $faker->sentence();
            $r->ots = $faker->randomElement($ots);
            $r->positive_points = $faker->numberBetween(5,25);
            $r->negative_points = $faker->numberBetween(100,135);
            $r->modifier = $faker->randomFloat(2, 0.8, 1);
            $r->save();
        }
    }

}
