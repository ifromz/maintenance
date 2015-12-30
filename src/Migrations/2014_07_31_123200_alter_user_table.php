<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'username')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('username');

                    $table->unique('username');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
}
