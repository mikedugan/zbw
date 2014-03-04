<?php

class ControllersTableSeeder extends Seeder {


	public function run()
	{
		DB::table('controllers')->truncate();
		Eloquent::unguard();
		$faker = Faker\Factory::create();

		$ratings = ['I3', 'I1', 'C3', 'C1', 'S3', 'S2', 'S1', 'O'];

		$c = new User();
		$c->cid = 1240047;
		$c->initials = "DA";
		$c->first_name = 'Mike';
		$c->last_name = 'Dugan';
		$c->username = $c->first_name . ' ' . $c->last_name;
		$c->password = Hash::make('Mickeyd2!');
		$c->email = 'mike@mjdugan.com';
		$c->rating = "C1";
		$c->signature = 'Mike Dugan, Webmaster';
		$c->artcc = "ZBW";
		$c->is_active = 1;
		$c->is_mentor = 1;
		$c->is_webmaster = 1;
		$c->is_staff = 1;
		$c->save();

		$c = new User();
		$c->cid = 1170055;
		$c->initials = "BU";
		$c->first_name = 'Rich';
		$c->last_name = 'Bonneau';
		$c->username = strtoupper($c->first_name . ' ' . $c->last_name);
		$c->password = Hash::make('1234');
		$c->email = 'rich@bostonartcc.net';
		$c->signature = 'Rich Bonneau - ATM';
		$c->rating = "S3";
		$c->artcc = "ZBW";
		$c->is_active = 1;
		$c->is_mentor = 1;
		$c->is_atm = 1;
		$c->is_staff = 1;
		$c->save();

		$c = new User();
		$c->cid = 1544047;
		$c->initials = "WY";
		$c->first_name = 'Mike';
		$c->last_name = 'Willey';
		$c->username = $c->first_name . ' ' . $c->last_name;
		$c->password = Hash::make('1234');
		$c->email = 'mike@bostonartcc.net';
		$c->signature = "Mike Willey, TA";
		$c->rating = "I3";
		$c->artcc = "ZBW";
		$c->is_active = 1;
		$c->is_ta = 1;
		$c->is_instructor = 1;
		$c->is_staff = 1;
		$c->save();

		foreach(range(1,50) as $i)
		{
			$c = new User();
			$c->cid = $faker->randomNumber(7);
			$c->initials = $faker->randomLetter() . $faker->randomLetter();
			$c->first_name = $faker->firstName();
			$c->last_name = $faker->lastName();
			$c->username = $c->first_name . ' ' . $c->last_name;
			$c->password = Hash::make($faker->word());
			$c->email = $faker->safeEmail();
			$c->signature = $c->first_name . ' ' . $c->last_name . '('.$c->initials.')';
			$c->rating = $faker->randomElement($ratings);
			$c->artcc = 'ZBW';
			$c->is_active = $faker->boolean(70);
			$c->is_mentor = $faker->boolean(5);
			$c->save();
		}
	}

}
