<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssignedDelegation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('positions', function($table)
	    {
		    $table->integer('user_id')->unsigned()->index()->nullable();
		    $table->foreign('user_id')->references('id')->on('users');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('positions', function($table)
	    {
		    $table->dropColumn('user_id');
	    });
    }
}
