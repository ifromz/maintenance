<?php

use Illuminate\Database\Migrations\Migration;

class AlterUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'username')) {
                Schema::table('users', function (Closure $table) {
                    $table->string('username')->after('email');
                    $table->unique('username');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}