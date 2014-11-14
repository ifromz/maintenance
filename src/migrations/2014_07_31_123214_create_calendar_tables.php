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
            Schema::create('calendars', function(Blueprint $table)
            {
                $table->increments('id');
                $table->timestamps();
                $table->integer('calendarable_id');
                $table->string('calendarable_type');
                $table->string('name');
                $table->text('description')->nullable();
            });
            
            Schema::create('calendar_events', function(Blueprint $table)
            {
                $table->increments('id');
                $table->timestamps();
                $table->integer('calendar_id')->unsigned();
                $table->integer('parent_id')->nullable();
                $table->integer('user_id')->unsigned();
                $table->string('title');
                $table->text('description')->nullable();
                $table->timestamp('start');
                $table->timestamp('end');
                $table->tinyInteger('allDay')->default(0);
                $table->string('color')->nullable();
                $table->string('background_color')->nullable();
                $table->string('recur_frequency')->nullable();
                $table->string('recur_filter_days')->nullable();
                $table->string('recur_filter_months')->nullable();
                $table->string('recur_filter_years')->nullable();
                
                $table->foreign('calendar_id')->references('id')->on('calendars')
                                                ->onUpdate('restrict')
                                                ->onDelete('cascade');
                
                $table->foreign('user_id')->references('id')->on('users')
                                                ->onUpdate('restrict')
                                                ->onDelete('cascade');
                
            });
            
            Schema::create('calendar_event_reports', function(Blueprint $table)
            {
                $table->increments('id');
                $table->timestamps();
                $table->integer('user_id')->unsigned();
                $table->integer('event_id')->unsigned();
                $table->text('description');
                
                $table->foreign('user_id')->references('id')->on('users')
                                                ->onUpdate('restrict')
                                                ->onDelete('cascade');
                
                 $table->foreign('event_id')->references('id')->on('calendar_events')
                                                ->onUpdate('restrict')
                                                ->onDelete('cascade');
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
                
                $table->foreign('event_id')->references('id')->on('calendar_events')
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
            Schema::drop('calendar_event_reports');
            Schema::drop('calendar_events');
            Schema::drop('calendars');
	}

}
