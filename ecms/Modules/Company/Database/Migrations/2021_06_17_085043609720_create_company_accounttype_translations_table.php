<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyAccountTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company__accounttype_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('accounttype_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['accounttype_id', 'locale']);
            $table->foreign('accounttype_id')->references('id')->on('company__accounttypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company__accounttype_translations', function (Blueprint $table) {
            $table->dropForeign(['accounttype_id']);
        });
        Schema::dropIfExists('company__accounttype_translations');
    }
}
