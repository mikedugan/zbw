<?php
use Faker\Factory as Faker;
class ControllerexamsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		DB::table('controller_exams')->truncate();
        $answers = ['a', 'b', 'c', 'd'];

		foreach(range(1,250) as $c)
		{
            //set up the number of wrong answers and generate the incorrect answers
            $wrong = $faker->randomNumber(0,8);
            $wronga = "";
            for($i = 0; $i <= $wrong; $i++)
            {
                $wronga .= $faker->randomElement($answers) + ",";
            }

			$e = new ControllerExam();
			$e->exam_id = $faker->randomNumber(0,12);
            $e->reviewed = $faker->boolean(80);
            $e->wrong_questions = $wrong;
            $e->wrong_answers = $wronga;
            $e->total_questions = 20;
			$e->save();
		}
	}

}
