<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('committee');
	        $table->string('full_name');
            $table->string('topic');
            $table->string('chair_email');
	        $table->string('chair_name');
	        $table->boolean('high_school');
	        $table->integer('clone_of')->unsigned()->index()->nullable();
	        $table->foreign('clone_of')->references('id')->on('committees')->onDelete('cascade');
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
        Schema::drop('committees');
    }
}
