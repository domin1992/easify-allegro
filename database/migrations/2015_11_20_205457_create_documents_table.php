<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('documents', function (Blueprint $table) {
          $table->increments('id');
          $table->string('owner');
          $table->string('name');
          $table->text('hash');
          $table->longtext('content');
          $table->integer('template');
          $table->boolean('generated');
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
        Schema::drop('documents');
    }
}