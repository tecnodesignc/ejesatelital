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
            $table->unique(['neighborhood_id', 'locale'],'location__neighborhood__id_locale_unique');
            $table->foreign('neighborhood_id','location__neighborhood_translations')->references('id')->on('location__neighborhoods')->onDelete('cascade');
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
            $table->dropForeign('location__neighborhood_translations');
        });
        Schema::dropIfExists('location__neighborhood_translations');
    }
}

