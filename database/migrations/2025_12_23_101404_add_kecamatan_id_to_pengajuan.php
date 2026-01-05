<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKecamatanIdToPengajuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->foreign('kecamatan_id')
                ->references('id')
                ->on('kecamatans')
                ->onDelete('cascade');

            $table->text('nama_kecamatan')->nullable();

            $table->text('alasan_tolak')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            //
        });
    }
}
