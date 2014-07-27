<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCompletedOnToControllerExamsTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('controller_exams', function (Blueprint $table) {
            $table->timestamp('completed_on');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('controller_exams', function (Blueprint $table) {
            $table->dropColumn('completed_on');
        });
    }

}
