<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAirportChartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('AirportCharts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('icao', 4)->required();
			$table->string('type', 4);
			$table->string('name', 100);
			$table->string('filename', 100);
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
		Schema::drop('AirportCharts');
	}

}
