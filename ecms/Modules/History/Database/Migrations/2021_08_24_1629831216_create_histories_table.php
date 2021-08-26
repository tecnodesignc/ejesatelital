<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('history__histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->string('type')->nullable();
            $table->string('title');
            $table->string('message')->nullable();;
            $table->string('ip')->nullable();;
            $table->string('lng')->nullable();;
            $table->string('lat')->nullable();;
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('history__histories');
    }
}
