<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCidToZbwuploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('zbw_uploads', function(Blueprint $table)
        {
            $table->dropColumn('parent_type');
        });
        Schema::table('zbw_uploads', function(Blueprint $table) {
           $table->integer('cid')->required();
           $table->tinyInteger('parent_type');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::table('zbw_uploads', function(Blueprint $table) {
            $table->dropColumn('cid');
            $table->dropColumn('parent_type');
            $table->enum('parent_type', ['message', 'forum', 'download']);
        });
        Schema::table('zbw_uploads', function(Blueprint $table) {
            $table->enum('parent_type', ['message', 'forum', 'download']);
        });
	}

}
