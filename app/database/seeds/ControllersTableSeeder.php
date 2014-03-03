<?php

class ControllersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('controllers')->truncate();

		$c = new User();
		$c->cid = 1240047;
		$c->initials = "DA";
		$c->first_name = 'Mike';
		$c->last_name = 'Dugan';
		$c->username = $c->first_name . ' ' . $c->last_name;
		$c->password = Hash::make('Mickeyd2!');
		$c->email = 'mike@mjdugan.com';
		$c->rating = "C1";
		$c->artcc = "ZBW";
		$c->is_active = 1;
		$c->is_mentor = 1;
		$c->is_webmaster = 1;
		$c->is_staff = 1;
		$c->save();

		$controllers = array(

		);

		// Uncomment the below to run the seeder
		// DB::table('controllers')->insert($controllers);
	}

}
