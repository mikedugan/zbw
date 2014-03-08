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
			$table->enum('weather', ['vfr', 'mvfr', 'ifr'])->default('vfr');
			$table->enum('complexity',['very_easy', 'easy', 'moderate', 'hard', 'very_hard'])->default('very_easy');
			$table->enum('workload', ['light', 'medium', 'heavy'])->default('light');
			$table->text('staff_comment');
			$table->text('student_comment');
			$table->boolean('is_ots')->default(0);
			$table->enum('position', ['PVD_GND', 'PVD_TWR', 'PWM_TWR', 'PWM_GND', 'PVD_APP', 'PWM_APP',
				'BOS_GND', 'BOS_TWR', 'BOS_APP', 'BOS_CTR'])->required();
			$table->tinyInteger('brief_time')->unsigned()->required()->default(0);
			$table->tinyInteger('position_time')->unsigned()->required()->default(0);
			$table->boolean('is_live')->default(0);
			$table->enum('training_type', ['sb_training', 'sb_familiarization', 'network_training']);
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
