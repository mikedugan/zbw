<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class NewsTableSeeder extends Seeder {

    public function run()
    {
	      DB::table('zbw_news')->truncate();
	      $facility = ['ZBW', 'A90', 'G90', 'Y90', 'PWM', 'ZNY', 'CYUL', 'CYYZ'];
        $faker = Faker::create();
        foreach(range(1, 50) as $index)
        {
          $n = new News();
          $n->news_type = $faker->randomNumber(0,4);
          $n->audience = $faker->randomNumber(0,2);
          $n->title = $faker->sentence(2);
          $n->content = $faker->realText();
          $n->starts = $faker->dateTimeThisDecade('2014-06-12 12:55:30');
          $n->ends = $faker->dateTimeThisDecade('2014-06-12 12:55:30');
          $n->facility = $faker->randomElement($facility);
	      $n->save();
        }
    }

}
