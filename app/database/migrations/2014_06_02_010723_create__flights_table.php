<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFlightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_flights', function(Blueprint $table) {
        $table->increments('id');
        $table->integer('cid');
        $table->string('callsign');
        $table->string('departure');
        $table->string('destination');
        $table->string('route');
        $table->string('name');
        $table->string('aircraft');
        $table->string('altitude');
        $table->string('eta');
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
		Schema::drop('_flights');
	}

}
