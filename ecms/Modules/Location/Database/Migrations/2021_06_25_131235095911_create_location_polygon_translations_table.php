<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationPolygonTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location__polygon_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('polygon_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['polygon_id', 'locale']);
            $table->foreign('polygon_id')->references('id')->on('location__polygons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location__polygon_translations', function (Blueprint $table) {
            $table->dropForeign(['polygon_id']);
        });
        Schema::dropIfExists('location__polygon_translations');
    }
}
