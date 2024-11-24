<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNamaMapelToJurnalKelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jurnal_kelas', function (Blueprint $table) {
            if(!Schema::hasColumn('jurnal_kelas', 'nama_mapel'))
            $table->string('nama_mapel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jurnal_kelas', function (Blueprint $table) {
            //
        });
    }
}
