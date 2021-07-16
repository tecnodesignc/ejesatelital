<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsQuestionTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls__questiontype_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('questiontype_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['questiontype_id', 'locale']);
            $table->foreign('questiontype_id')->references('id')->on('polls__questiontypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polls__questiontype_translations', function (Blueprint $table) {
            $table->dropForeign(['questiontype_id']);
        });
        Schema::dropIfExists('polls__questiontype_translations');
    }
}