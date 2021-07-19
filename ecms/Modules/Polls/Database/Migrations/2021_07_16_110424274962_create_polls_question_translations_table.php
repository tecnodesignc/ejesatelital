<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsQuestionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls__question_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('statement');
            $table->text('description')->nullable();
            $table->integer('question_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['question_id', 'locale']);
            $table->foreign('question_id')->references('id')->on('polls__questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polls__question_translations', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });
        Schema::dropIfExists('polls__question_translations');
    }
}
