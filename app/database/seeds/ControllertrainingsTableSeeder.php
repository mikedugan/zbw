<?php

use Faker\Factory as Faker;

class ControllertrainingsTableSeeder extends Seeder {


	public function run()
	{
		$weather = ['vfr', 'mvfr', 'ifr'];
		$complexity = ['very_easy', 'easy', 'moderate', 'hard', 'very_hard'];
		$workload = ['light', 'medium', 'heavy'];
		$position = ['PVD_GND', 'PVD_TWR', 'PWM_TWR', 'PWM_GND', 'PVD_APP', 'PWM_APP',
		'BOS_GND', 'BOS_TWR', 'BOS_APP', 'BOS_CTR'];
		$type = ['sb_training', 'sb_familiarization', 'network_training'];

		DB::table('controller_training')->truncate();
		$faker = Faker::create();
		foreach(range(1,150) as $index)
		{
			$t = new ControllerTraining();
			$t->cid = $faker->randomNumber(1,50);
			$t->sid = $faker->randomNumber(1,50);
			$t->session_date = $faker->dateTimeThisDecade();
			$t->weather = $faker->randomElement($weather);
			$t->complexity = $faker->randomElement($complexity);
			$t->workload = $faker->randomElement($workload);
			$t->staff_comment = $faker->realText();
			$t->student_comment = $faker->realText();
			$t->is_ots = $faker->boolean(30);
			$t->position = $faker->randomElement($position);
			$t->brief_time = $faker->randomNumber(1,30);
			$t->position_time = $faker->randomNumber(30,60);
			$t->is_live = $faker->boolean(40);
			$t->training_type = $faker->randomElement($type);
			$t->save();
		}
	}

}
