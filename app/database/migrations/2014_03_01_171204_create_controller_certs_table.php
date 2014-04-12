<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateControllerCertsTable extends Migration {

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
			$table->tinyInteger('cert_type_id')->default(0);
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
