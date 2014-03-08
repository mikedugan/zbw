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
		Schema::create('controller_certs', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cid')->required();
			$table->enum('exam_id', ['C_S1','B_S1', 'C_S2','B_S2', 'C_S3','B_S3','C'])->required();
			$table->boolean('passed')->required();
			$table->tinyInteger('times_taken')->default(0);
			$table->date('first_exam');
			$table->date('last_exam');
			$table->date('first_request');
			$table->date('last_request');
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
		Schema::drop('controller_certs');
	}

}
