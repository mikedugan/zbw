<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TsKey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zbw_tskeys', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cid');
			$table->string('ts_key', 8);
			$table->string('computer_id', 50);
			$table->string('created', 32);
			$table->boolean('status');
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
		Schema::drop('zbw_tskeys');
	}

}
