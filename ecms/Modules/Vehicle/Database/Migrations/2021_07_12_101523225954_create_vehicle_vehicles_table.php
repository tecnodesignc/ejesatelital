<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle__vehicles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('board');
            $table->string('model');
            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('vehicle__brands')->onDelete('cascade');
            $table->integer('type_vehicle')->unsigned();
            $table->date('insurance_expiration');
            $table->date('technomechanical_expiration');
            $table->text('options')->nullable();
            $table->timestamps();
            $table->unique('board');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle__vehicles');
    }
}
