<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('device_id', 128)->unique();
            $table->string('access_token', 128)->unique();

            $table->boolean('verified')->default(true);

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
        Schema::drop('users');
    }
}
