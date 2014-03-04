<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class NewsTableSeeder extends Seeder {

    public function run()
    {
	      DB::table('zbw_news')->truncate();
	      $types = ['event', 'news', 'policy', 'forum', 'staff'];
	      $audience = ['pilots', 'controllers', 'both'];
	      $facility = ['ZBW', 'A90', 'G90', 'Y90', 'PWM', 'ZNY', 'CYUL', 'CYYZ'];
        $faker = Faker::create();
        foreach(range(1, 50) as $index)
        {
          $n = new News();
          $n->type = $faker->randomElement($types);
          $n->audience = $faker->randomElement($audience);
          $n->title = $faker->sentence(5);
          $n->content = $faker->realText();
          //$n->starts = $faker->optional()->dateTimeThisYear();
          //$n->ends = $faker->optional()->dateTimeThisYear();
          $n->facility = $faker->randomElement($facility);
	        $n->save();
        }
    }

}