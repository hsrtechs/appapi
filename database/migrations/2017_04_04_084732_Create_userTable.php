<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('password');
            $table->string('number')->unique();
            $table->string('email')->unique();
            $table->string('country');
            $table->integer('credits', false, true)->default(0);
            $table->string('device_id')->unique();
            $table->string('referral_token')->unique();
            $table->string('access_token')->unique();
            $table->integer('user_id')->unsigned();
            $table->boolean('verified')->default(true);

            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
