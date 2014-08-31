<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTerminatedToUsersTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('terminated')->default(false);
            $table->boolean('guest')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('terminated');
            $table->dropColumn('guest');
        });
    }

}
