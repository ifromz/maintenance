<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('events', function(Blueprint $table)
            {
                $table->increments('id');
                $table->timestamps();
                $table->integer('user_id')->unsigned()->nullable();
                $table->string('title');
                $table->text('description')->nullable();
                $table->timestamp('start');
                $table->timestamp('end');
                $table->tinyInteger('allDay')->default(0);
                $table->string('color')->nullable();
                $table->string('background_color')->nullable();
                $table->string('recur_frequency')->nullable();
                $table->integer('recur_count')->nullable();
                $table->string('recur_filter_days')->nullable();
                $table->string('recur_filter_months')->nullable();
                $table->string('recur_filter_years')->nullable();
                
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('set null');
            });
            
            Schema::create('asset_events', function(Blueprint $table)
            {
                $table->increments('id');
                $table->timestamps();
                $table->integer('user_id')->unsigned()->nullable();
                $table->integer('asset_id')->unsigned();
                $table->integer('event_id')->unsigned();
                
                $table->foreign('user_id')->references('id')->on('users')
						->onUpdate('restrict')
						->onDelete('set null');
                
                $table->foreign('asset_id')->references('id')->on('assets')
						->onUpdate('restrict')
						->onDelete('cascade');
                
                $table->foreign('event_id')->references('id')->on('events')
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
            Schema::drop('asset_events');
            Schema::drop('events');
	}

}
