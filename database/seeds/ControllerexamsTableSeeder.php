<?php
use Faker\Factory as Faker;

class ControllerexamsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();
        DB::table('controller_exams')->truncate();
        $answers = ['a', 'b', 'c', 'd'];
        $cids = \User::lists('cid');
        $sid = [1240047, 1544047, 1170055];
        foreach (range(1, 250) as $c) {
            //set up the number of wrong answers and generate the incorrect answers
            $wrong = $faker->numberBetween(0, 8);
            $wronga = "";
            $wrongq = "";
            for ($i = 0; $i <= $wrong; $i++) {
                $wronga .= $faker->randomElement($answers) . ",";
                $wrongq .= $faker->numberBetween(0, 20) . ",";
            }

            $e = new Exam();
            $e->cid = $faker->randomElement($cids);
            $e->reviewed_by = $faker->randomElement($sid);
            $e->exam_id = $faker->numberBetween(0, 6);
            $e->reviewed = $faker->boolean(80);
            $e->wrong_questions = $wrongq;
            $e->wrong_answers = $wronga;
            $e->total_questions = 20;
            $e->cert_id = $faker->numberBetween(1, 5);
            $e->save();
        }
    }
}
