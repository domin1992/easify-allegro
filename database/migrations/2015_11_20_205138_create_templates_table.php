<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('templates', function (Blueprint $table) {
          $table->increments('id');
          $table->string('owner');
          $table->string('name');
          $table->text('hash');
          $table->longtext('content');
          $table->string('var_start');
          $table->string('var_end');
          $table->string('version');
          $table->string('permission');
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
        Schema::drop('templates');
    }
}
