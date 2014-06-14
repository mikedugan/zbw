<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_ratings', function(Blueprint $table)
		{
	      $table->integer('id');
        $table->string('short', 3);
        $table->string('medium', 20);
        $table->string('long', 30);
        $table->string('grp', 30);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('_ratings');
	}

}
