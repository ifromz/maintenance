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
			$table->bigIncrements('id');
			$table->timestamps();
                        $table->bigInteger('asset_id')->unsigned();
			$table->bigInteger('attachment_id')->unsigned();
			$table->string('name')->nullable();
			
                        $table->foreign('asset_id')->references('id')->on('assets')
						->onUpdate('restrict')
						->onDelete('cascade');
                        
			$table->foreign('attachment_id')->references('id')->on('attachments')
						->onUpdate('restrict')
						->onDelete('cascade');
		});
		
		Schema::create('asset_images', function(Blueprint $table){
			$table->bigIncrements('id');
			$table->timestamps();
                        $table->bigInteger('asset_id')->unsigned();
			$table->bigInteger('attachment_id')->unsigned();
			$table->string('name')->nullable();
			
                        $table->foreign('asset_id')->references('id')->on('assets')
						->onUpdate('restrict')
						->onDelete('cascade');
                        
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
