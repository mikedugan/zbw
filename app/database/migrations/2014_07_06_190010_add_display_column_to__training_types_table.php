<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDisplayColumnToTrainingTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('_training_types', function(Blueprint $table)
		{
			$table->string('display');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('_training_types', function(Blueprint $table)
		{
        $table->dropColumn('display');
		});
	}

}
