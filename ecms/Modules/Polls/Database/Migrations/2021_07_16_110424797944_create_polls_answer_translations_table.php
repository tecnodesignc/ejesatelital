<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsAnswerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls__answer_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('title');
            $table->text('caption');
            $table->integer('answer_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['answer_id', 'locale']);
            $table->foreign('answer_id')->references('id')->on('polls__answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polls__answer_translations', function (Blueprint $table) {
            $table->dropForeign(['answer_id']);
        });
        Schema::dropIfExists('polls__answer_translations');
    }
}
