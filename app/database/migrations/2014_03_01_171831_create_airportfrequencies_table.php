<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAirportFrequenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('airport_frequencies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('icao', 4)->required();
			$table->string('name', 20);
			$table->string('freq1', 7);
			$table->string('freq2', 7);
			$table->string('freq3', 7);
			$table->string('freq4', 7);
			$table->string('freq5', 7);
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
		Schema::drop('airport_frequencies');
	}

}
