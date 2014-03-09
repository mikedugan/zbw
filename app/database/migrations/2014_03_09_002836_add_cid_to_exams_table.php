<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCidToExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('controller_exams', function(Blueprint $table) {
            $table->integer('cid');
            $table->integer('reviewed_by');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::table('controller_exams', function(Blueprint $table) {
            $table->dropColumn('cid');
            $table->dropColumn('reviewed_by');
        });
	}

}
