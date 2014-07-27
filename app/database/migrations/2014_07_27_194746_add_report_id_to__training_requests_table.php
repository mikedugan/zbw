<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddReportIdToTrainingRequestsTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('_training_requests', function (Blueprint $table) {
			      $table->integer('training_session_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('_training_requests', function (Blueprint $table) {
            $table->dropColumn('training_session_id');
        });
    }

}
