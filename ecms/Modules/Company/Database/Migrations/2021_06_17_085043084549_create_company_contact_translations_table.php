<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyContactTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company__contact_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('contact_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['contact_id', 'locale']);
            $table->foreign('contact_id')->references('id')->on('company__contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company__contact_translations', function (Blueprint $table) {
            $table->dropForeign(['contact_id']);
        });
        Schema::dropIfExists('company__contact_translations');
    }
}
