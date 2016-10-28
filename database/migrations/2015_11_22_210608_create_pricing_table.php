<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pricing', function (Blueprint $table) {
          $table->increments('id');
          $table->string('package');
          $table->string('package_without_accented');
          $table->integer('count');
          $table->float('price');
          $table->string('currency');
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
        Schema::drop('pricing');
    }
}
