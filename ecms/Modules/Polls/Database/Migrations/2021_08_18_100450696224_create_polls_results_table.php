<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls__results', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->json('answer_id')->nullable();
            $table->text('respond')->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->string('ip');
            $table->integer('fill')->unsigned();
            $table->unique(['answer_id', 'fill']);
            $table->foreign('question_id')->references('id')->on('polls__questions')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('company__accounts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
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
        Schema::table('blog__posts', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->dropForeign(['account_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('polls__results');
    }
}
