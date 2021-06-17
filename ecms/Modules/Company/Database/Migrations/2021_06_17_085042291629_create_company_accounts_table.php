<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company__accounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('name');
            $table->string('nit');
            $table->text('account_site');
            $table->integer('parent');
            $table->integer('account_type_id');
            $table->string('phone');
            $table->text('street');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->text('options')->nullable();


            // Your fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company__accounts');
    }
}
