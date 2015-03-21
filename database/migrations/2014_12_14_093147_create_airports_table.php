<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAirportsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icao', 4);
            $table->string('airspace', 1);
            $table->string('iata', 3);
            $table->string('name');
            $table->string('lat');
            $table->string('lon');
            $table->smallInteger('elevation');
            $table->string('tracon');
            $table->string('location');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('airports');
    }

}
