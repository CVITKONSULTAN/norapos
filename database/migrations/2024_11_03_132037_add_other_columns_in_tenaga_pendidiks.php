<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherColumnsInTenagaPendidiks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenaga_pendidiks', function (Blueprint $table) {
            $table->string('nik')->nullable();
            $table->string('tahun_sertifikasi')->nullable();
            $table->string('nbm')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('mulai_bertugas')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('status_kepegawaian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenaga_pendidiks', function (Blueprint $table) {
            //
        });
    }
}
