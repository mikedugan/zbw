<?php
use Faker\Factory as Faker;
class ControllerexamsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		DB::table('controller_exams')->truncate();

		$exams = ['C_GND', 'C_TWR', 'C_APP', 'B_GND', 'B_TWR', 'B_APP', 'CTR'];

		foreach(range(1,250) as $c)
		{
			$e = new ControllerExam();
			$e->cid = $faker->randomNumber(1,50);
			$e->exam = $faker->randomElement($exams);
			$e->passed = $faker->boolean(80);
			$e->times_taken = $faker->randomNumber(1,2);
			$e->first_exam = $faker->dateTimeThisYear();
			$e->last_exam = $faker->dateTimeThisYear();
			$e->first_request = $faker->dateTimeThisYear();
			$e->last_request = $faker->dateTimeThisYear();
			$e->save();
		}
	}

}
