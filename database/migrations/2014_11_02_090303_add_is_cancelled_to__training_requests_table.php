<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIsCancelledToTrainingRequestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('_training_requests', function (Blueprint $table) {
            $table->boolean('is_cancelled')->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_training_requests', function (Blueprint $table) {
            $table->dropColumn('is_cancelled');
        });
    }

}
