<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyAccountTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company__account_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('account_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['account_id', 'locale']);
            $table->foreign('account_id')->references('id')->on('company__accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company__account_translations', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
        });
        Schema::dropIfExists('company__account_translations');
    }
}
