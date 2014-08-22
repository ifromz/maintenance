<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetManualsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asset_manuals', function(Blueprint $table){
			$table->increments('id');
			$table->timestamps();
			$table->integer('attachment_id')->unsigned();
			$table->string('name')->nullable();
			
			$table->foreign('attachment_id')->references('id')->on('attachments')
						->onUpdate('restrict')
						->onDelete('cascade');
		});
		
		Schema::create('asset_images', function(Blueprint $table){
			$table->increments('id');
			$table->timestamps();
			$table->integer('attachment_id')->unsigned();
			$table->string('name')->nullable();
			
			$table->foreign('attachment_id')->references('id')->on('attachments')
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
		Schema::drop('asset_images');
		Schema::drop('asset_manuals');
	}

}
