<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
      $this->call('GroupsTableSeeder');
		$this->call('ControllersTableSeeder');
		$this->call('ControllertrainingsTableSeeder');
		$this->call('ControllerexamsTableSeeder');
		$this->call('AirportrunwaysTableSeeder');
		$this->call('AirportroutesTableSeeder');
		$this->call('AirportgeosTableSeeder');
		$this->call('AirportfrequenciesTableSeeder');
		$this->call('AirportchartsTableSeeder');
		$this->call('PokercardsTableSeeder');
		$this->call('PilotfeedbacksTableSeeder');
		$this->call('NewsTableSeeder');
        $this->call('ReferenceTableSeeder');
        $this->call('ActionsTableSeeder');
        $this->call('ControllerReportsTableSeeder');
        $this->call('PrivateMessageTableSeeder');
        $this->call('TrainingRequestsTableSeeder');
      $this->call('ForumsTableSeeder');
      $this->call('UserSettingsTableSeeder');
	}

}
