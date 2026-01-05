<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSessionCapacitiesToPpdbSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb_settings', function (Blueprint $table) {
             // kolom baru untuk kuota per sesi
            $table->json('session_capacities')->nullable()
                ->after('sessions'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppdb_settings', function (Blueprint $table) {
            $table->dropColumn('session_capacities');
        });
    }
}
