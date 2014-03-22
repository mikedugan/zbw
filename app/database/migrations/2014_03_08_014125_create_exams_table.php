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
        Schema::create('controller_exams', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('exam_id');
            $table->date('assigned_on')->nullable();
            $table->tinyInteger('cert_id')->default(0);
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
	    Schema::drop('controller_exams');
	}

}
