<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatatanTengahToKelasSiswas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelas_siswas', function (Blueprint $table) {
            $table->mediumText('catatan_tengah')->nullable();
            $table->mediumText('catatan_akhir')->nullable();
            $table->mediumText('kesimpulan')->nullable();
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
