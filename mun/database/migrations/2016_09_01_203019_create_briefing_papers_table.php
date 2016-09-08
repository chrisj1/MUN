<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBriefingPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('briefing_papers', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('committee_id')->unsigned()->index()->nullable();
	        $table->foreign('committee_id')->references('id')->on('committees');
	        $table->string('name');
	        $table->string('file_path');
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
        Schema::drop('briefing_papers');
    }
}
