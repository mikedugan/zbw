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
			$table->tinyInteger('news_type_id')->default(1);
			$table->tinyInteger('audience_type_id')->default(1);
			$table->string('title', 60)->required();
			$table->text('content')->required();
			$table->timestamp('starts')->nullable();
			$table->timestamp('ends')->nullable();
			$table->tinyInteger('facility_id')->nullable();
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
