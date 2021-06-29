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
            $table->string('nit')->nullable();
            $table->text('account_site')->nullable();
            $table->integer('parent_id')->default(0);
            $table->boolean('active')->default(-1);
            $table->integer('account_type_id')->unsigned();
            $table->string('phone')->nullable();
            $table->text('street')->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('province_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
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
