<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTrainingReportsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('controller_training_reports');
        Schema::create('controller_training_reports', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('training_session_id');
              $table->tinyInteger('brief');
              $table->tinyInteger('runway');
              $table->tinyInteger('weather');
              $table->tinyInteger('coordination');
              $table->tinyInteger('flow');
              $table->tinyInteger('identity');
              $table->tinyInteger('separation');
              $table->tinyInteger('pointouts');
              $table->tinyInteger('airspace');
              $table->tinyInteger('loa');
              $table->tinyInteger('phraseology');
              $table->tinyInteger('priority');
              $table->text('markups');
              $table->text('markdown');
              $table->text('reviewed');
              $table->tinyInteger('ots');
              $table->smallInteger('positive_points');
              $table->smallInteger('negative_points');
              $table->float('modifier');

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
        Schema::drop('controller_training_reports');
        Schema::table(
          'controller_training_reports', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('training_session_id');
              $table->enum('o_brief', ['s', 'ni', 'u']);
              $table->enum('o_runway', ['s', 'ni', 'u']);
              $table->enum('o_weather', ['s', 'ni', 'u']);
              $table->enum('o_coordination', ['s', 'ni', 'u']);
              $table->enum('o_flow', ['s', 'ni', 'u']);
              $table->enum('o_identity', ['s', 'ni', 'u']);
              $table->enum('o_separation', ['s', 'ni', 'u']);
              $table->enum('o_pointouts', ['s', 'ni', 'u']);
              $table->enum('o_knowledge', ['s', 'ni', 'u']);
              $table->enum('o_phraseology', ['s', 'ni', 'u']);
              $table->enum('o_priority', ['s', 'ni', 'u']);
              $table->text('markups');
              $table->text('markdown');
              $table->text('reviewed');
              $table->text('summary');
              $table->smallInteger('s_ppoints');
              $table->smallInteger('s_npoints');
              $table->float('s_modifier');
          }
        );
    }

}
