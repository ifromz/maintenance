<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->string('message');
            $table->string('before')->nullable();
            $table->string('after')->nullable();
            $table->tinyInteger('read')->default(0);
            $table->string('link');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('restrict')
                ->onDelete('cascade');

        });

        Schema::create('notifiables', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();
            $table->integer('notifiable_id');
            $table->string('notifiable_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifiables');
        Schema::drop('notifications');
    }

}
