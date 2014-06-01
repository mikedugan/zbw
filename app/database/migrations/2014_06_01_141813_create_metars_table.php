<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetarsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metars', function(Blueprint $table) {
			  $table->increments('id');
        $table->string('facility');
        $table->string('raw');
        $table->integer('time');
        $table->integer('wind_direction')->nullable();
        $table->integer('wind_speed')->nullable();
        $table->integer('wind_gusts')->nullable();
        $table->tinyInteger('visibility');
        $table->string('sky');
        $table->integer('temp');
        $table->integer('dewpoint');
        $table->string('altimeter');
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
		Schema::drop('metars');
	}

}
