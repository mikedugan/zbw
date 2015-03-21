<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropGuestFromUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('users', function(Blueprint $table) {
            $table->dropColumn('guest');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('users', function(Blueprint $table) {
            $table->boolean('guest')->default(true);
        });
    }

}
