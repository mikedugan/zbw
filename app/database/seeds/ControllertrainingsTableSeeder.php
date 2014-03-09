<?php

use Faker\Factory as Faker;

class ControllertrainingsTableSeeder extends Seeder {


	public function run()
	{
        $cid = [190632, 273648, 3001257, 93182, 1394942, 1720206, 3275607];
        $sid = [1240047, 1544047, 1170055];

		DB::table('controller_training')->truncate();
		$faker = Faker::create();
		foreach(range(1,150) as $index)
		{
			$t = new ControllerTraining();
			$t->cid = $faker->randomElement($cid);
			$t->sid = $faker->randomElement($sid);
			$t->session_date = $faker->dateTimeThisDecade('2014-06-12 12:55:30');
			$t->weather = $faker->randomNumber(0,2);
			$t->complexity = $faker->randomNumber(0,4);
			$t->workload = $faker->randomNumber(0,2);
			$t->staff_comment = $faker->realText();
			$t->student_comment = $faker->realText();
			$t->is_ots = $faker->boolean(30);
			$t->facility = $faker->randomNumber(0,12);
			$t->brief_time = $faker->randomNumber(1,30);
			$t->position_time = $faker->randomNumber(30,60);
			$t->is_live = $faker->boolean(40);
			$t->training_type = $faker->randomNumber(0,2);
			$t->save();
		}
	}

}
