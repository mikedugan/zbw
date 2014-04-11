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
			$table->tinyInteger('news_type')->default(0);
			$table->tinyInteger('audience')->default(0);
			$table->string('title', 60)->required();
			$table->text('content')->required();
			$table->timestamp('starts')->nullable();
			$table->timestamp('ends')->nullable();
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
