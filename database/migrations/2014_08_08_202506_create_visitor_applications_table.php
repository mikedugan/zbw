<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVisitorApplicationsTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cid');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('rating');
            $table->string('division');
            $table->string('home')->default('');
            $table->text('message')->default('');
            $table->text('comments')->default('');
            $table->boolean('accepted');
            $table->timestamp('accepted_on');
            $table->integer('accepted_by');
            $table->boolean('lor_submitted')->default(0);
            $table->timestamp('lor_submitted_on')->nullable();
            $table->text('lor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('visitor_applications');
    }

}
