<?php

// Composer: "fzaninotto/faker": "v1.3.0"

class TrainingRequestsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('_training_requests')->truncate();
        $faker = Faker\Factory::create();
        $cids = \User::lists('cid');
        foreach (range(1, 30) as $index) {
            $tr = new TrainingRequest();
            $tr->start = $faker->dateTime();
            $tr->end = $faker->dateTime();
            $tr->cert_id = $faker->randomElement([1, 2, 3, 4, 5, 6]);
            $tr->cid = $faker->randomElement($cids);
            $tr->save();
        }
    }

}
