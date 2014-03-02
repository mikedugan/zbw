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
		Schema::create('airport_runways', function(Blueprint $table) {
			$table->increments('id');
			$table->string('icao', 4);
			$table->string('runway', 7);
			$table->integer('heading');
			$table->integer('full_length');
			$table->integer('width');
			$table->integer('takeoff_dist');
			$table->integer('landing_dist');
			$table->string('ils_freq', 7);
			$table->string('ils_ident', 4);
			$table->string('ils_cat', 4);
			$table->integer('ils_course');
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
		Schema::drop('airport_runways');
	}

}
