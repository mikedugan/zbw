<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPublishedColumnToPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('zbw_pages', function(Blueprint $table)
		{
			$table->tinyInteger('published');
        $table->dropColumn('is_staff_only');
        $table->dropColumn('is_web_only');
        $table->dropColumn('is_exec_only');
        $table->integer('audience_type_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('zbw_pages', function(Blueprint $table)
		{
			$table->dropColumn('published');
        $table->boolean('is_staff_only');
        $table->boolean('is_web_only');
        $table->boolean('is_exec_only');
        $table->dropColumn('audience_type_id');
		});
	}

}
