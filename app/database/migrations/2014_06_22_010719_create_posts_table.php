<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
        $table->increments('id');
        $table->string('title', 60)->default("No subject");
        $table->text('content')->required();
        $table->integer('cid')->required();
        $table->integer('thread_id')->required();
        $table->integer('views');
        $table->boolean('has_attachments')->default(0);
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
		Schema::drop('posts');
	}

}
