<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnsToControllerExamsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('controller_exams', function (Blueprint $table) {
              $table->dropColumn('wrong_questions');
              $table->dropColumn('wrong_answers');
              $table->dropColumn('exam_id');
              $table->dropColumn('cert_id');
              $table->integer('cert_type_id');
              $table->integer('correct');
              $table->integer('wrong');
              $table->text('exam');
              $table->text('questions');
              $table->boolean('pass');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('controller_exams', function (Blueprint $table) {
              $table->dropColumn('cert_type_id');
              $table->dropColumn('questions');
              $table->dropColumn('exam');
              $table->dropColumn('wrong');
              $table->dropColumn('correct');
              $table->dropColumn('pass');
              $table->string('wrong_questions');
              $table->string('wrong_answers');
              $table->integer('cert_id');
              $table->integer('exam_id');
        });
    }

}
