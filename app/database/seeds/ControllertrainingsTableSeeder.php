<?php

use Faker\Factory as Faker;

class ControllertrainingsTableSeeder extends Seeder {


	public function run()
	{
        $cid = [6728094, 8859385, 3423026, 190632, 85000057, 3207799, 3423026];
        $sid = [1240047, 1544047, 1170055];

		DB::table('controller_training')->truncate();
		$faker = Faker::create();
		foreach(range(1,150) as $index)
		{
			$t = new ControllerTraining();
			$t->cid = $faker->randomElement($cid);
			$t->sid = $faker->randomElement($sid);
			$t->session_date = $faker->dateTimeThisDecade('2014-06-12 12:55:30');
			$t->weather = $faker->randomNumber(1,3);
			$t->complexity = $faker->randomNumber(1,5);
			$t->workload = $faker->randomNumber(1,3);
			$t->staff_comment = $faker->realText();
			$t->student_comment = $faker->realText();
			$t->is_ots = $faker->boolean(30);
			$t->facility = $faker->randomNumber(1,13);
			$t->brief_time = $faker->randomNumber(1,30);
			$t->position_time = $faker->randomNumber(30,60);
			$t->is_live = $faker->boolean(40);
			$t->training_type = $faker->randomNumber(1, 3);
			$t->save();
		}
	}

}
