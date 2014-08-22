<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplyTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('supplies', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('supply_category_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('name');
			$table->string('description')->nullable();
			$table->string('make')->nullable();
			$table->string('model')->nullable();
			$table->string('serial')->nullable();
			$table->text('notes')->nullable();
			
			$table->foreign('supply_category_id')->references('id')->on('supply_categories')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('user_id')->references('id')->on('users')
						->onUpdate('restrict')
						->onDelete('cascade');
		});
		
		Schema::create('supply_attachments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('supply_id')->unsigned();
			$table->integer('attachment_id')->unsigned();
			
			$table->foreign('supply_id')->references('id')->on('supplies')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('attachment_id')->references('id')->on('attachments')
						->onUpdate('restrict')
						->onDelete('cascade');
		});
		
		
		
		Schema::create('supply_locations', function(Blueprint $table){
			$table->increments('id');
			$table->timestamps();
			$table->integer('supply_id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->decimal('quantity', 10, 2);
			
			$table->foreign('supply_id')->references('id')->on('supplies')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('location_id')->references('id')->on('locations')
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
		Schema::drop('supply_locations');
		Schema::drop('supply_attachments');
		Schema::drop('supplies');
	}

}
