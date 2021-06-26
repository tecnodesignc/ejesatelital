<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location__countries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('status')->default('1');
            $table->string('currency');
            $table->text('currency_symbol');
            $table->text('currency_code');
            $table->text('currency_sub_unit');

            $table->text('region_code');
            $table->text('sub_region_code');

            $table->integer('country_code')->unsigned();
            $table->string('iso_2',2);
            $table->string('iso_3',3);
            $table->integer('calling_code')->unsigned();
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
        Schema::dropIfExists('location__countries');
    }
}
