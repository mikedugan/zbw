<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAirportGeosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('airport_geo', function(Blueprint $table) {
			$table->increments('id');
			$table->string('icao', 4)->required();
			$table->string('airspace', 1);
			$table->string('faa_id', 3);
			$table->string('name', 40);
			$table->string('lat', 10);
			$table->string('lon', 10);
			$table->smallIn('elevation')->required()->default(0);
			$table->string('tracon', 20);
			$table->string('location', 50);
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
		Schema::drop('airport_geo');
	}

}
