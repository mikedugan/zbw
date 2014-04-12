<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ControllerReportsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        DB::table('controller_training_reports')->truncate();
        $lev = ['s', 'ni', 'u'];
        foreach(range(1, 150) as $index)
        {
            $r = new TrainingReport();
            $r->training_session_id = $index;
            $r->o_brief = $faker->randomElement($lev);
            $r->o_runway = $faker->randomElement($lev);
            $r->o_weather = $faker->randomElement($lev);
            $r->o_coordination = $faker->randomElement($lev);
            $r->o_flow = $faker->randomElement($lev);
            $r->o_identity = $faker->randomElement($lev);
            $r->o_separation = $faker->randomElement($lev);
            $r->o_pointouts = $faker->randomElement($lev);
            $r->o_knowledge = $faker->randomElement($lev);
            $r->o_phraseology = $faker->randomElement($lev);
            $r->o_priority = $faker->randomElement($lev);
            $r->markups = $faker->sentence();
            $r->markdown = $faker->sentence();
            $r->reviewed = $faker->sentence();
            $r->summary = $faker->paragraph();
            $r->s_npoints = $faker->randomNumber(5,25);
            $r->s_ppoints = $faker->randomNumber(100,135);
            $r->s_modifier = $faker->randomFloat(2, 0.8, 1);
            $r->save();
        }
    }

}
