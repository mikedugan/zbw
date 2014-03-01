<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAirportRunwaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('AirportRunways', function(Blueprint $table) {
			$table->increments('id');
			$table->string('icao', 4);
			$table->string('runway', 7);
			$table->integer('heading', 3);
			$table->integer('full_length', 5);
			$table->integer('width', 3);
			$table->integer('takeoff_dist', 5);
			$table->integer('landing_dist', 5);
			$table->string('ils_freq', 7);
			$table->string('ils_ident', 4);
			$table->string('ils_cat', 4);
			$table->integer('ils_course', 5);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('AirportRunways');
	}

}
