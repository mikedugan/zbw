<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateControllerTrainingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('controller_training', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cid')->required();
			$table->integer('sid')->required();
			$table->dateTime('session_date');
			$table->tinyInteger('weather')->default(0);
			$table->tinyInteger('complexity')->default(0);
			$table->tinyInteger('workload')->default(0);
			$table->text('staff_comment');
			$table->text('student_comment');
			$table->boolean('is_ots')->default(0);
			$table->tinyInteger('facility')->default(0)->required(0);
			$table->tinyInteger('brief_time')->unsigned()->required()->default(0);
			$table->tinyInteger('position_time')->unsigned()->required()->default(0);
			$table->boolean('is_live')->default(0);
			$table->tinyInteger('training_type')->default(0)->unsigned();
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
		Schema::drop('controller_training');
	}

}
