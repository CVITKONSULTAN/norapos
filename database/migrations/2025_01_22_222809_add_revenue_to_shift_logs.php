<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRevenueToShiftLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shift_logs', function (Blueprint $table) {
            $table->integer('total_cash')->default(0);
            $table->integer('total_transfer')->default(0);
            $table->integer('total_room')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shift_logs', function (Blueprint $table) {
            //
        });
    }
}
