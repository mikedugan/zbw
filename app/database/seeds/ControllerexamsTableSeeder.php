<?php
use Faker\Factory as Faker;
class ControllerexamsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		DB::table('controller_exams')->truncate();
        $answers = ['a', 'b', 'c', 'd'];
        $cid = [6728094, 8859385, 3423026, 190632, 85000057, 3207799, 3423026];
        $sid = [1240047, 1544047, 1170055];
		foreach(range(1,250) as $c)
		{
            //set up the number of wrong answers and generate the incorrect answers
            $wrong = $faker->randomNumber(0,8);
            $wronga = "";
            $wrongq = "";
            for($i = 0; $i <= $wrong; $i++)
            {
                $wronga .= $faker->randomElement($answers) . ",";
                $wrongq .= $faker->randomNumber(0,20) . ",";
            }



			$e = new ControllerExam();
            $e->cid = $faker->randomElement($cid);
            $e->reviewed_by = $faker->randomElement($sid);
			$e->exam_id = $faker->randomNumber(0,6);
            $e->reviewed = $faker->boolean(80);
            $e->wrong_questions = $wrongq;
            $e->wrong_answers = $wronga;
            $e->total_questions = 20;
			$e->save();
		}
	}

}
