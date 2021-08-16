<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleVehicleAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle__vehicle_account', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->foreign('vehicle_id')->references('id')->on('vehicle__vehicles')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('company__accounts')->onDelete('cascade');
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
        Schema::table('vehicle__vehicle_account', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['account_id']);
        });
        Schema::dropIfExists('vehicle__vehicle_account');
    }
}
