<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAirportRoutesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('airport_routes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('orig_icao', 4);
			$table->string('dest_icao', 4);
			$table->string('route');
			$table->string('hours', 20);
			$table->string('type', 4);
			$table->string('area');
			$table->string('altitude');
			$table->string('aircraft');
			$table->string('direction');
			$table->integer('sequence')->required()->default(0);
			$table->string('orig_artcc', 3);
			$table->string('dest_artcc', 3);
			$table->integer('stale');
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
		Schema::drop('airport_routes');
	}

}
