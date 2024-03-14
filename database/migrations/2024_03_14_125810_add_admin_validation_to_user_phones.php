<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminValidationToUserPhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_phones', function (Blueprint $table) {
            $table->boolean('isAdmin')->default(0);
            $table->longtext('adminToken')->nullable();
            $table->longtext('log_uid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_phones', function (Blueprint $table) {
            //
        });
    }
}
