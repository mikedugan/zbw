<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateControllerExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('controller_exams', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cid')->required();
			$table->string('exam', 30)->required();
			$table->boolean('passed')->required();
			$table->integer('times_taken')->default(0);
			$table->date('first_exam');
			$table->date('last_exam');
			$table->date('first_request');
			$table->date('last_request');
			$table->boolean('certified_peak')->default(0);
			$table->boolean('certified_offpeak')->default(0);
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
		Schema::drop('controller_exams');
	}

}
