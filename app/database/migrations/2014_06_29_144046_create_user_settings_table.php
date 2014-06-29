<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          'user_settings',
          function (Blueprint $table) {
              $table->integer('cid')->required();
              $table->tinyInteger('n_private_message')->default(2);
              $table->tinyInteger('n_exam_assigned')->default(2);
              $table->tinyInteger('n_exam_comment')->default(1);
              $table->tinyInteger('n_training_accepted')->default(2);
              $table->tinyInteger('n_training_cancelled')->default(2);
              $table->tinyInteger('n_events')->default(0);
              $table->tinyInteger('n_news')->default(0);
              $table->tinyInteger('n_exam_request')->default(1)->nullable();
              $table->tinyInteger('n_staff_exam_comment')->default(1)->nullable();
              $table->tinyInteger('n_training_request')->default(1)->nullable();
              $table->tinyInteger('n_staff_news')->default(1)->nullable();
          }
        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_settings');
    }

}
