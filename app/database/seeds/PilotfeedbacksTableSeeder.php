<?php

use Faker\Factory as Faker;

class PilotfeedbacksTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('pilot_feedback')->truncate();
		$faker = Faker::create();
		foreach(range(1,250) as $i)
		{
			$f = new PilotFeedback();
			$f->controller = $faker->randomNumber(1, 50);
			$f->rating = $faker->randomNumber(1,5);
			$f->name = $faker->name();
			$f->email = $faker->safeEmail();
			$f->ip = $faker->ipv4();
			$f->comments = $faker->text();
			$f->save();
		}

	}

}
