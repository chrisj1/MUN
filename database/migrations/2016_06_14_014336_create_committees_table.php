<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommitteesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('committees', function (Blueprint $table) {
			$table->increments('id');
			$table->string('committee');
			$table->string('full_name');
			$table->string('topic');
			$table->integer('chair')->unsigned()->index()->nullable()->references('id')->on('users');
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
	public function down() {
		Schema::drop('committees');
	}
}
