<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location__cities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code', 6);

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('location__countries')->onDelete('cascade');

            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('location__provinces')->onDelete('cascade');
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
        Schema::dropIfExists('location__cities');
    }
}
