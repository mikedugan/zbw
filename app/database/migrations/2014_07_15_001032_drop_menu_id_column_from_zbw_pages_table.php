<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropMenuIdColumnFromZbwPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('zbw_pages', function(Blueprint $table) {
          $table->dropColumn('menu_id');
      });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('zbw_pages', function(Blueprint $table) {
          $table->integer('menu_id');
      });
	}

}
