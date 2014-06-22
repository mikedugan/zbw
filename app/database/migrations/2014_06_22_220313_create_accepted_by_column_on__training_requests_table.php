<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcceptedByColumnOnTrainingRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('_training_requests', function(Blueprint $table)
		{
	      $table->integer('accepted_by')->nullable();
        $table->dateTime('accepted_at')->nullable();
        $table->boolean('is_completed')->default(0);
        $table->dateTime('completed_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('_training_requests', function(Blueprint $table)
		{
			  $table->dropColumn('accepted_by');
        $table->dropColumn('accepted_at');
        $table->dropColumn('is_completed');
        $table->dropColumn('completed_at');
		});
	}

}
