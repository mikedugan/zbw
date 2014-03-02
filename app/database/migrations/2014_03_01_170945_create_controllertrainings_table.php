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
			$table->date('session_date');
			$table->integer('weather')->default("0");
			$table->integer('workload')->default(0);
			$table->integer('complexity')->default(0);
			$table->text('staff_comment');
			$table->text('student_comment');
			$table->boolean('is_ots')->default(0);
			$table->string('position', 30)->required();
			$table->integer('brief_time')->required()->default(0);
			$table->integer('position_time')->required()->default(0);
			$table->boolean('is_live')->default(0);
			$table->integer('training_type')->default(0);
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
