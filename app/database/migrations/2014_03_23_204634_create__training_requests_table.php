<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrainingRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_training_requests', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('cid');
            $table->integer('sid')->nullable()->default(null);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->tinyInteger('cert');
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
		Schema::drop('_training_requests');
	}

}
