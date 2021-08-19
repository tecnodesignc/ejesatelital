<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls__questions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('type');
            $table->text('options')->nullable();
            $table->integer('poll_id')->unsigned();
            $table->foreign('poll_id')->references('id')->on('polls__polls')->onDelete('cascade');
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
        Schema::table('polls__questions', function (Blueprint $table) {
            $table->dropForeign(['poll_id']);
        });
        Schema::dropIfExists('polls__questions');
    }
}
