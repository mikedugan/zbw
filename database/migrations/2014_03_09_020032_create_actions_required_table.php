<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionsRequiredTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('zbw_actionsrequired', function(Blueprint $table) {
            $table->increments('id');
            $table->boolean('resolved')->default(0);
            $table->integer('resolved_by')->nullable();
            $table->string('url');
            $table->integer('cid');
            $table->string('title', 120);
            $table->text('description');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('zbw_actionsrequired');
	}

}
