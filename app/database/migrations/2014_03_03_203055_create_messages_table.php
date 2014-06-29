<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          'zbw_messages',
          function (Blueprint $table) {
              $table->increments('id');
              $table->integer('from')->required();
              $table->integer('to')->required();
              $table->string('subject', 150)->default('No subject');
              $table->text('content')->required();
              $table->boolean('has_attachments')->default(0);
              $table->boolean('is_read')->default(0);
              $table->text('history')->nullable();
              $table->integer('cid')->required();
              $table->softDeletes();
              $table->timestamps();
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
        Schema::drop('zbw_messages');
    }

}
