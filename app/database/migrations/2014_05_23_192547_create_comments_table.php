<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zbw_comments', function(Blueprint $table) {
              $table->increments('id');
              $table->integer('author')->required();
              $table->text('content')->required();
              $table->integer('comment_type')->required();
              $table->integer('parent_id')->required();
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
        Schema::drop('zbw_comments');
    }

}
