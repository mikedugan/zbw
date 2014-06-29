<?php

class UserSettingsTableSeeder extends Seeder {

	public function run()
	{
      DB::table('user_settings')->truncate();
      $users = \User::all();
      foreach($users as $user) {
          $s = new UserSettings();
          $s->cid = $user->cid;
          if(!$user->is_staff) {
              $s->n_exam_request = null;
              $s->n_staff_exam_comment = null;
              $s->n_training_request = null;
              $s->n_staff_news = null;
          }
          $s->save();
      }
	}

}
