<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zbw_pages', function(Blueprint $table) {
				$table->increments('id');
				$table->string('title');
				$table->integer('author');
				$table->text('content');
				$table->boolean('is_official');
				$table->tinyInteger('menu_id');
				$table->boolean('is_staff_only');
				$table->boolean('is_exec_only');
				$table->boolean('is_web_only');
				$table->tinyInteger('template_id');
				$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zbw_pages');
	}

}
