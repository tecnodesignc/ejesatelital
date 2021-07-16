<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleVehicleDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle__vehicle_driver', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id')->unsigned();
            $table->integer('driver_id')->unsigned();
            $table->foreign('vehicle_id')->references('id')->on('vehicle__vehicles')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on(config('auth.table', 'users'))->onDelete('cascade');

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
        Schema::table('vehicle__vehicle_driver', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['driver_id']);
        });
        Schema::dropIfExists('vehicle__vehicle_driver');
    }
}
