<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersOrderDeclarationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users_order_declaration', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user');
          $table->string('method');
          $table->string('package');
          $table->double('price', 16, 16);
          $table->boolean('confirmation')->default(0);
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
        Schema::drop('users_order_declaration');
    }
}
