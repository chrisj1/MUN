<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePositionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('positions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('committee_id')->unsigned()->index()->nullable();
			$table->foreign('committee_id')->references('id')->on('committees');
			$table->string('name');
			$table->integer('delegate')->unsigned()->index()->nullable();
			$table->foreign('delegate')->references('id')->on('delegates');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('positions');
	}
}
