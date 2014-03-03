<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateControllersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('controllers', function(Blueprint $table) {
			$table->string('username', 60)->unique()->required();
			$table->integer('cid', 8)->unique()->required();
			$table->string('initials', 2)->required();
			$table->string('first_name', 30)->required();
			$table->string('last_name', 30)->required();
			$table->string('password')->required();
			$table->string('email', 60)->unique()->required();
			$table->string('rating', 3)->required();
			$table->string('artcc', 3)->required()->default('ZBW');
			$table->string('signature', 255);
			$table->boolean('is_mentor')->default(0);
			$table->boolean('is_instructor')->default(0);
			$table->boolean('is_facilities')->default(0);
			$table->boolean('is_webmaster')->default(0);
			$table->boolean('is_atm')->default(0);
			$table->boolean('is_datm')->default(0);
			$table->boolean('is_ta')->default(0);
			$table->boolean('is_emeritus')->default(0);
			$table->boolean('is_active');
			$table->boolean('is_staff')->default(0);
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
		Schema::drop('controllers');
	}

}
