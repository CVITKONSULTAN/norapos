<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHitunganSistemToKelasSiswas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelas_siswas', function (Blueprint $table) {
            if(!Schema::hasColumn('kelas_siswas', 'hitungan_sistem'))
            $table->json('hitungan_sistem')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelas_siswas', function (Blueprint $table) {
            //
        });
    }
}
