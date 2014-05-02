<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateControllerSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zbw_controller_settings', function(Blueprint $table) {
				$table->integer('cid');
				$table->boolean('email_is_hidden');
				$table->boolean('receive_email_notifications');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zbw_controller_settings');
	}

}
