<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateZbwPokercardsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
          'zbw_pokercards', function (Blueprint $table) {
              $table->dropColumn('card');
              $table->dropColumn('time_dealt');
              $table->dropColumn('discarded');
		    });
        Schema::table(
          'zbw_pokercards', function (Blueprint $table) {
              $table->string('card', 6);
              $table->datetime('discarded')->nullable();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
          'zbw_pokercards', function (Blueprint $table) {
              $table->dropColumn('card');
              $table->dropColumn('discarded');
          });
        Schema::table(
          'zbw_pokercards', function (Blueprint $table) {
              $table->string('card', 3);
              $table->date('time_dealt');
              $table->datetime('discarded');
          });
    }

}
