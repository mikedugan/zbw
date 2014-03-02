<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forum_posts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 60)->default("No subject");
			$table->text('content')->required();
			$table->integer('user_id')->required();
			$table->integer('topic_id')->required();
			$table->integer('views');
			$table->boolean('has_attachments')->default(0);
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
		Schema::drop('forum_posts');
	}

}
