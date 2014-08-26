<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('work_orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
                        $table->integer('location_id')->unsigned();
			$table->integer('work_order_category_id')->unsigned();
			$table->integer('status_id')->unsigned();
			$table->integer('priority')->nullable();
			$table->dateTime('started_at')->nullable();
			$table->dateTime('completed_at')->nullable();
			$table->string('subject');
			$table->text('description')->nullable();
			$table->decimal('hours', 5, 2)->nullable();
			
			$table->foreign('user_id')->references('id')->on('users')
						->onUpdate('restrict')
						->onDelete('cascade');
			
                        $table->foreign('location_id')->references('id')->on('locations')
						->onUpdate('restrict')
						->onDelete('cascade');
                        
			$table->foreign('work_order_category_id')->references('id')->on('work_order_categories')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('status_id')->references('id')->on('statuses')
						->onUpdate('restrict')
						->onDelete('cascade');
		});
		
		Schema::create('work_order_attachment', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('work_order_id')->unsigned();
			$table->integer('attachment_id')->unsigned();
			$table->integer('user_id')->unsigned();
			
			$table->foreign('work_order_id')->references('id')->on('work_orders')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('attachment_id')->references('id')->on('attachments')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('user_id')->references('id')->on('users')
						->onUpdate('restrict')
						->onDelete('cascade');
		});
		
		Schema::create('work_order_supplies', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('work_order_id')->unsigned();
			$table->integer('supply_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->decimal('quantity', 5, 2);
			
			$table->foreign('work_order_id')->references('id')->on('work_orders')
						->onUpdate('restrict')
						->onDelete('cascade');
						
			$table->foreign('supply_id')->references('id')->on('supplies')
						->onUpdate('restrict')
						->onDelete('cascade');
						
			$table->foreign('user_id')->references('id')->on('users')
						->onUpdate('restrict')
						->onDelete('cascade');
		});
		
		Schema::create('work_order_assets', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('work_order_id')->unsigned();
			$table->integer('asset_id')->unsigned();
			
			$table->foreign('work_order_id')->references('id')->on('work_orders')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('asset_id')->references('id')->on('assets')
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
		Schema::drop('work_order_assets');
		Schema::drop('work_order_attachment');
		Schema::drop('work_order_supplies');
		Schema::drop('work_orders');
	}

}
