<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePPDBSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_p_d_b_sekolahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->json('detail');
            $table->enum('status_siswa',[
                'MENUNGGU VERIFIKASI',
                'DITERIMA',
                'DITOLAK'
            ])->default('MENUNGGU VERIFIKASI');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_p_d_b_sekolahs');
    }
}
