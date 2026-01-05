<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePpdbSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up(): void
    {
        Schema::create('ppdb_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('close_ppdb')->default(false)->comment('Apakah pendaftaran ditutup');
            $table->date('tgl_penerimaan')->nullable()->comment('Tanggal pengumuman/penerimaan');
            $table->integer('min_bulan')->default(0)->comment('Minimal umur dalam bulan');
            $table->integer('min_tahun')->default(0)->comment('Minimal umur dalam tahun');
            $table->string('tahun_ajaran', 20)->nullable()->comment('Contoh: 2025/2026');

            $table->integer('jumlah_tagihan')->default(0)->comment('Biaya pendaftaran');
            $table->string('nama_bank', 100)->nullable();
            $table->string('no_rek', 100)->nullable();
            $table->string('atas_nama', 150)->nullable();

            $table->timestamps();
        });

        // 🧩 Insert default setting langsung setelah tabel dibuat
        DB::table('ppdb_settings')->insert([
            'close_ppdb' => false,
            'tgl_penerimaan' => '2026-01-01',
            'min_bulan' => 6,
            'min_tahun' => 5,
            'tahun_ajaran' => '2025/2026',
            'jumlah_tagihan' => 350000,
            'nama_bank' => 'Bank Kalbar',
            'no_rek' => '00000',
            'atas_nama' => 'SD Muhammadiyah 2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_settings');
    }
    
}
