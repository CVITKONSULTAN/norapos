<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengajuanTable extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('no_permohonan')->unique();
            $table->enum('tipe',['PBG','SLF','PBG/SLF'])->default('PBG');
            $table->string('no_krk')->nullable();
            $table->string('nama_pemohon')->nullable();
            $table->string('nik', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('fungsi_bangunan')->nullable();
            $table->string('nama_bangunan')->nullable();
            $table->string('jumlah_bangunan')->nullable();
            $table->string('jumlah_lantai')->nullable();
            $table->string('luas_bangunan')->nullable();
            $table->text('lokasi_bangunan')->nullable();

            // Info Tanah
            $table->string('no_persil')->nullable();
            $table->string('luas_tanah')->nullable();
            $table->string('pemilik_tanah')->nullable();
            $table->string('gbs_min')->nullable();
            $table->string('kdh_min')->nullable();
            $table->string('kdb_max')->nullable();

            // Jika file upload ingin disimpan sebagai JSON array URL
            $table->json('uploaded_files')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
}
