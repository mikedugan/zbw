<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAvatarColumnToUserSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
          'user_settings',
          function (Blueprint $table) {
              $table->string('avatar')->nullable();
              $table->boolean('email_hidden')->default(true);
              $table->string('signature')->default('');
              $table->string('ts_key')->default('');
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
        Schema::table(
          'user_settings',
          function (Blueprint $table) {
              $table->dropColumn('avatar');
          }
        );
    }

}
