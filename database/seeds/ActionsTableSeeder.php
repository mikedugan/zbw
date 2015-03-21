<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ActionsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('zbw_actionsrequired')->truncate();
        $faker = Faker::create();
        $cid = [190632, 273648, 3001257, 93182, 1394942, 1720206, 3275607];
        foreach(range(1, 30) as $index)
        {
            $a = new ActionRequired();
            $a->resolved = 0;
            $a->resolved_by = 0;
            $a->url = $faker->url();
            $a->cid = $faker->randomElement($cid);
            $a->title = implode(' ', $faker->words(6));
            $a->description = $faker->sentence();
            $a->save();
        }
    }

}
