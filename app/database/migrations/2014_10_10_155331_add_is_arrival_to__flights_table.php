<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIsArrivalToFlightsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('_flights', function (Blueprint $table) {
            $table->boolean('is_arrival')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_flights', function (Blueprint $table) {
            $table->dropColumn('is_arrival');
        });
    }
}
