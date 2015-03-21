<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cid')->required();
            $table->boolean('SOP_assigned')->default(0);
            $table->string('SOP_checked_off')->default(0);
            $table->boolean('C_S1_assigned')->default(0);
            $table->string('C_S1_checked_off')->default(0);
            $table->boolean('V_S1_assigned')->default(0);
            $table->string('V_S1_checked_off')->default(0);
            $table->boolean('B_S1_assigned')->default(0);
            $table->string('B_S1_checked_off')->default(0);
            $table->boolean('C_S2_assigned')->default(0);
            $table->string('C_S2_checked_off')->default(0);
            $table->boolean('V_S2_assigned')->default(0);
            $table->string('V_S2_checked_off')->default(0);
            $table->boolean('B_S2_assigned')->default(0);
            $table->string('B_S2_checked_off')->default(0);
            $table->boolean('C_S3_assigned')->default(0);
            $table->string('C_S3_checked_off')->default(0);
            $table->boolean('V_S3_assigned')->default(0);
            $table->string('V_S3_checked_off')->default(0);
            $table->boolean('B_S3_assigned')->default(0);
            $table->string('B_S3_checked_off')->default(0);
            $table->boolean('C_assigned')->default(0);
            $table->string('C_checked_off')->default(0);
            $table->boolean('V_C_assigned')->default(0);
            $table->string('V_C_checked_off')->default(0);
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
        Schema::drop('exam_records');
    }

}
