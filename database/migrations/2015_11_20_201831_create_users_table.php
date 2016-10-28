<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('email')->unique();
          $table->string('password', 60);
          $table->text('activation');
          $table->boolean('activated')->default(0);
          $table->rememberToken();
          $table->boolean('admin')->default(0);
          $table->boolean('premium')->default(0);
          $table->dateTime('premium_until')->default('0000-00-00 00:00:00');
          $table->integer('base_limit_used')->default(0);
          $table->dateTime('base_limit_reset')->default('0000-00-00 00:00:00');
          $table->integer('premium_limit')->default(0);
          $table->integer('premium_limit_used')->default(0);
          $table->datetime('premium_limit_finished')->nullable()->default(NULL);
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
        Schema::drop('users');
    }
}
