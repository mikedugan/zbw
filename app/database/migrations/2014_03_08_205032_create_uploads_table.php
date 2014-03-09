<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('zbw_uploads', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->enum('parent_type', ['message', 'forum', 'download']);
            $table->string('name', 60);
            $table->string('description', 120);
            $table->string('location');
            $table->integer('type')->default(0);
            $table->string('mime');
            $table->integer('size');
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
	    Schema::drop('zbw_uploads');
	}

}
