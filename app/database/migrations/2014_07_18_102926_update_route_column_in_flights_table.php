<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateRouteColumnInFlightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('_flights', function(Blueprint $table)
		{
			$table->dropColumn('route');
		});
        Schema::table('_flights', function(Blueprint $table)
        {
            $table->text('route');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('_flights', function(Blueprint $table)
		{
			$table->dropColumn('route');
		});
        Schema::table('_flights', function(Blueprint $table)
        {
            $table->text('route');
        });
	}

}
