<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('_exam_questions', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('cert_type_id');
			$table->text('question');
            $table->string('answer_a');
            $table->string('answer_b');
            $table->string('answer_c');
            $table->string('answer_d')->nullable();
            $table->string('answer_e')->nullable();
            $table->string('answer_f')->nullable();
            $table->tinyInteger('correct')->nullable();
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('_exam_questions');
	}

}
