<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStaffAvailabilityTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_availability', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cid');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->integer('cert_id');
            $table->text('comment');
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
        Schema::drop('staff_availability');
    }
}
