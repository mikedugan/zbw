<?php

use Faker\Factory as Faker;

class ControllertrainingsTableSeeder extends Seeder {


	public function run()
	{
        $cids = \User::lists('cid');
        $sid = [1240047, 1544047, 1170055];
		$faker = Faker::create();
		foreach(range(1,150) as $index)
		{
			$t = new TrainingSession();
			$t->cid = $faker->randomElement($cids);
			$t->sid = $faker->randomElement($sid);
			$t->session_date = $faker->dateTimeThisDecade('2014-06-12 12:55:30');
			$t->weather_id = $faker->numberBetween(1,3);
			$t->complexity_id = $faker->numberBetween(1,5);
			$t->workload_id = $faker->numberBetween(1,3);
			$t->staff_comment = $faker->realText();
			$t->student_comment = $faker->realText();
			$t->is_ots = $faker->boolean(30);
			$t->facility_id = $faker->numberBetween(1,13);
			$t->brief_time = $faker->numberBetween(1,30);
			$t->position_time = $faker->numberBetween(30,60);
			$t->is_live = $faker->boolean(40);
			$t->training_type_id = $faker->numberBetween(1, 3);
			$t->save();
		}
	}

}
