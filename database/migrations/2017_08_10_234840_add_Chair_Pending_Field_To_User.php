<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChairPendingFieldToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('users', function ($table) {
		    $table->boolean('chair_pending')->default(false);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('users', function (Blueprint $table) {
		    $table->dropColumn('chair_pending');
	    });
    }
}
