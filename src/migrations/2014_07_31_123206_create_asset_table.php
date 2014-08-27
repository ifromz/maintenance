<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assets', function(Blueprint $table){
			$table->bigIncrements('id');
			$table->timestamps();
			$table->datetime('aquired_at')->nullable();
			$table->integer('user_id')->unsigned();
			$table->integer('location_id')->nullable()->unsigned();
			$table->integer('asset_category_id')->unsigned();
			$table->string('name');
			$table->integer('condition')->nullable();
			$table->string('size')->nullable();
			$table->string('weight')->nullable();
			$table->string('vendor')->nullable();
			$table->string('make')->nullable();
			$table->string('model')->nullable();
			$table->string('serial')->nullable();
			$table->decimal('price', 10, 2)->nullable();
			
			$table->foreign('user_id')->references('id')->on('users')
						->onUpdate('restrict')
						->onDelete('cascade');
			
			$table->foreign('location_id')->references('id')->on('locations')
						->onUpdate('restrict')
						->onDelete('set null');
						
			$table->foreign('asset_category_id')->references('id')->on('asset_categories')
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
		Schema::drop('assets');
	}

}
