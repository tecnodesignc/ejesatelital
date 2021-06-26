<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationNeighborhoodTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location__neighborhood_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('neighborhood_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['neighborhood_id', 'locale']);
            $table->foreign('neighborhood_id')->references('id')->on('location__neighborhoods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location__neighborhood_translations', function (Blueprint $table) {
            $table->dropForeign(['neighborhood_id']);
        });
        Schema::dropIfExists('location__neighborhood_translations');
    }
}
