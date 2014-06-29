<?php
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
          {
              $table->increments('cid');
              $table->string('email');
              $table->string('password');
              $table->text('permissions')->nullable();
              $table->boolean('activated')->default(0);
              $table->string('activation_code')->nullable();
              $table->timestamp('activated_at')->nullable();
              $table->timestamp('last_login')->nullable();
              $table->string('persist_code')->nullable();
              $table->string('reset_password_code')->nullable();
              $table->string('first_name')->nullable();
              $table->string('last_name')->nullable();
              $table->string('username', 60)->unique()->required();
              $table->string('remember_token', 100)->nullable();
              $table->string('initials', 2)->required();
              $table->tinyInteger('rating_id')->required();
              $table->tinyInteger('cert')->default(0);
              $table->string('artcc', 3)->required()->default('ZBW');
              $table->string('signature', 255);
              $table->boolean('is_mentor')->default(0);
              $table->boolean('is_instructor')->default(0);
              $table->boolean('is_facilities')->default(0);
              $table->boolean('is_webmaster')->default(0);
              $table->boolean('is_atm')->default(0);
              $table->boolean('is_datm')->default(0);
              $table->boolean('is_ta')->default(0);
              $table->boolean('is_emeritus')->default(0);
              $table->boolean('is_active')->default(0);
              $table->boolean('is_suspended')->default(0);
              $table->boolean('is_terminated')->default(0);
              $table->boolean('is_staff')->default(0);
              $table->timestamps();

              // We'll need to ensure that MySQL uses the InnoDB engine to
              // support the indexes, other engines aren't affected.
              $table->engine = 'InnoDB';
              $table->unique('email');
              $table->index('activation_code');
              $table->index('reset_password_code');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
