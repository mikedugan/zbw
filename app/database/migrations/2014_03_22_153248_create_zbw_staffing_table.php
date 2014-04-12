<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZbwStaffingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zbw_staffing', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cid');
            $table->string('position');
            $table->timestamp('start');
            $table->timestamp('stop');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zbw_staffing');
	}

}
