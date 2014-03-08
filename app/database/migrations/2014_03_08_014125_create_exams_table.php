<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('exams', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('exam_id', ['C_S1','B_S1', 'C_S2','B_S2', 'C_S3','B_S3','C'])->required();
            $table->boolean('reviewed')->default(0);
            $table->string('wrong_questions')->nullable();
            $table->string('wrong_answers')->nullable();
            $table->tinyInteger('total_questions');
			$table->timestamps('');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('exams');
	}

}
