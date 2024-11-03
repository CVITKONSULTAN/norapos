<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRekapAbsenToKelasSiswas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelas_siswas', function (Blueprint $table) {
            $table->integer('hadir')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('sakit')->default(0);
            $table->integer('tanpa_keterangan')->default(0);
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
