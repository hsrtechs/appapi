<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('install_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package');
            $table->string('device_id');
            $table->integer('user_id')->unsigned();
            $table->float('credits')->unsigned();
            $table->enum('type', [0, 1])->default(true);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('install_logs');
    }
}
