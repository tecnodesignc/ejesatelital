<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsPollTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls__poll_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('slug');
            $table->integer('poll_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['poll_id', 'locale']);
            $table->foreign('poll_id')->references('id')->on('polls__polls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polls__poll_translations', function (Blueprint $table) {
            $table->dropForeign(['poll_id']);
        });
        Schema::dropIfExists('polls__poll_translations');
    }
}
