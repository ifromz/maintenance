<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attachments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
                        $table->integer('user_id')->unsigned();
			$table->string('name')->nullable();
			$table->string('file_name');
			$table->text('file_path');
                        
                        $table->foreign('user_id')->references('id')->on('users')
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
		Schema::drop('attachments');
	}

}
