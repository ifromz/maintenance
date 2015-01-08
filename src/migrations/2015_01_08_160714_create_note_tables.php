<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('content');

			$table->foreign('user_id')->references('id')->on('users')
				->onUpdate('restrict')
				->onDelete('set null');
		});

		Schema::create('noteables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('note_id')->unsigned();
			$table->integer('noteable_id');
			$table->string('noteable_type');

			$table->foreign('note_id')->references('id')->on('notes')
				->onUpdate('restrict')
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
		Schema::drop('noteables');
		Schema::drop('notes');
	}

}
