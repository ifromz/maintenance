<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('work_order_id')->unsigned();
			$table->integer('by_user_id')->unsigned();
			$table->integer('to_user_id')->unsigned();
			
			$table->foreign('work_order_id')->references('id')->on('work_orders')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('by_user_id')->references('id')->on('users')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('to_user_id')->references('id')->on('users')
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
		Schema::drop('assignments');
	}

}
