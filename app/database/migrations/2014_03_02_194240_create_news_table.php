<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zbw_news', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('type', ['event', 'news', 'policy'])->required();
			$table->enum('audience', ['pilots', 'controllers', 'both'])->required();
			$table->string('title', 60)->required();
			$table->text('content')->required();
			$table->dateTime('starts')->nullable();
			$table->dateTime('ends')->nullable();
			$table->string('facility')->nullable();
			$table->softDeletes();
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
		Schema::drop('zbw_news');
	}

}
