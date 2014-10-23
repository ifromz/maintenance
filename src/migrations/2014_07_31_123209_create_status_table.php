<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('statuses', function(Blueprint $table)
            {
                $table->increments('id');
                $table->timestamps();
                $table->integer('user_id')->unsigned()->nullable();
                $table->string('name');
                $table->string('color');
                $table->integer('control')->default(0);
                
                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('set null');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('statuses');
	}

}
