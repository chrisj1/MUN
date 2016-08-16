<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnauthorizedAttempts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unathorizedAttempts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->integer('user_id')->unsigned()->index()->optional();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('unathorizedAttempts');
    }
}