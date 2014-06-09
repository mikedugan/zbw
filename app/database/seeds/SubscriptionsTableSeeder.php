<?php

use Faker\Factory as Faker;

class SubscriptionsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 20) as $index)
		{
			Subscription::create([

			]);
		}
	}

}
