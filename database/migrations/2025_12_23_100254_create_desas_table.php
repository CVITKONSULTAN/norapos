<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('kode');
            $table->string('nama');
            
            $table->unsignedBigInteger('kecamatan_id');
            $table->foreign('kecamatan_id')
                ->references('id')
                ->on('kecamatans')
                ->onDelete('cascade');

            $table->timestamps();
        });

        // =========================
        // SEEDER DESA (CONTOH UTAMA)
        // =========================

        // Ambil mapping kecamatan
        $kecamatan = DB::table('kecamatans')->pluck('id', 'nama');

        DB::table('desas')->insert([
            // =========================
            // BATU AMPAR
            // =========================
            ['kecamatan_id' => $kecamatan['Batu Ampar'], 'kode' => 'BA01', 'nama' => 'Batu Ampar'],
            ['kecamatan_id' => $kecamatan['Batu Ampar'], 'kode' => 'BA02', 'nama' => 'Padang Tikar I'],
            ['kecamatan_id' => $kecamatan['Batu Ampar'], 'kode' => 'BA03', 'nama' => 'Padang Tikar II'],
            ['kecamatan_id' => $kecamatan['Batu Ampar'], 'kode' => 'BA04', 'nama' => 'Nipah Panjang'],
            ['kecamatan_id' => $kecamatan['Batu Ampar'], 'kode' => 'BA05', 'nama' => 'Medan Mas'],

            // =========================
            // KUBU
            // =========================
            ['kecamatan_id' => $kecamatan['Kubu'], 'kode' => 'KB01', 'nama' => 'Kubu'],
            ['kecamatan_id' => $kecamatan['Kubu'], 'kode' => 'KB02', 'nama' => 'Batu Ampar'],
            ['kecamatan_id' => $kecamatan['Kubu'], 'kode' => 'KB03', 'nama' => 'Teluk Nibung'],
            ['kecamatan_id' => $kecamatan['Kubu'], 'kode' => 'KB04', 'nama' => 'Seruat Dua'],
            ['kecamatan_id' => $kecamatan['Kubu'], 'kode' => 'KB05', 'nama' => 'Sungai Kubu'],

            // =========================
            // TERENTANG
            // =========================
            ['kecamatan_id' => $kecamatan['Terentang'], 'kode' => 'TR01', 'nama' => 'Terentang'],
            ['kecamatan_id' => $kecamatan['Terentang'], 'kode' => 'TR02', 'nama' => 'Sungai Radak'],
            ['kecamatan_id' => $kecamatan['Terentang'], 'kode' => 'TR03', 'nama' => 'Teluk Pakedai Hulu'],
            ['kecamatan_id' => $kecamatan['Terentang'], 'kode' => 'TR04', 'nama' => 'Permata'],
            ['kecamatan_id' => $kecamatan['Terentang'], 'kode' => 'TR05', 'nama' => 'Banyuraya'],

            // =========================
            // SUNGAI RAYA
            // =========================
            ['kecamatan_id' => $kecamatan['Sungai Raya'], 'kode' => 'SR01', 'nama' => 'Arang Limbung'],
            ['kecamatan_id' => $kecamatan['Sungai Raya'], 'kode' => 'SR02', 'nama' => 'Sungai Raya Dalam'],
            ['kecamatan_id' => $kecamatan['Sungai Raya'], 'kode' => 'SR03', 'nama' => 'Sungai Raya'],
            ['kecamatan_id' => $kecamatan['Sungai Raya'], 'kode' => 'SR04', 'nama' => 'Madu Sari'],
            ['kecamatan_id' => $kecamatan['Sungai Raya'], 'kode' => 'SR05', 'nama' => 'Kapur'],
            ['kecamatan_id' => $kecamatan['Sungai Raya'], 'kode' => 'SR06', 'nama' => 'Parit Baru'],

            // =========================
            // SUNGAI AMBAWANG
            // =========================
            ['kecamatan_id' => $kecamatan['Sungai Ambawang'], 'kode' => 'SA01', 'nama' => 'Ambawang Kuala'],
            ['kecamatan_id' => $kecamatan['Sungai Ambawang'], 'kode' => 'SA02', 'nama' => 'Ambawang'],
            ['kecamatan_id' => $kecamatan['Sungai Ambawang'], 'kode' => 'SA03', 'nama' => 'Durian'],
            ['kecamatan_id' => $kecamatan['Sungai Ambawang'], 'kode' => 'SA04', 'nama' => 'Lingga'],
            ['kecamatan_id' => $kecamatan['Sungai Ambawang'], 'kode' => 'SA05', 'nama' => 'Teluk Bakung'],

            // =========================
            // SUNGAI KAKAP
            // =========================
            ['kecamatan_id' => $kecamatan['Sungai Kakap'], 'kode' => 'SK01', 'nama' => 'Sungai Kakap'],
            ['kecamatan_id' => $kecamatan['Sungai Kakap'], 'kode' => 'SK02', 'nama' => 'Pal Sembilan'],
            ['kecamatan_id' => $kecamatan['Sungai Kakap'], 'kode' => 'SK03', 'nama' => 'Punggur Kecil'],
            ['kecamatan_id' => $kecamatan['Sungai Kakap'], 'kode' => 'SK04', 'nama' => 'Punggur Besar'],
            ['kecamatan_id' => $kecamatan['Sungai Kakap'], 'kode' => 'SK05', 'nama' => 'Sungai Rengas'],

            // =========================
            // TELUK PAKEDAI
            // =========================
            ['kecamatan_id' => $kecamatan['Teluk Pakedai'], 'kode' => 'TP01', 'nama' => 'Teluk Pakedai'],
            ['kecamatan_id' => $kecamatan['Teluk Pakedai'], 'kode' => 'TP02', 'nama' => 'Tanjung Beringin'],
            ['kecamatan_id' => $kecamatan['Teluk Pakedai'], 'kode' => 'TP03', 'nama' => 'Sejegi'],
            ['kecamatan_id' => $kecamatan['Teluk Pakedai'], 'kode' => 'TP04', 'nama' => 'Mekar Utama'],

            // =========================
            // RASAU JAYA
            // =========================
            ['kecamatan_id' => $kecamatan['Rasau Jaya'], 'kode' => 'RJ01', 'nama' => 'Rasau Jaya Umum'],
            ['kecamatan_id' => $kecamatan['Rasau Jaya'], 'kode' => 'RJ02', 'nama' => 'Rasau Jaya I'],
            ['kecamatan_id' => $kecamatan['Rasau Jaya'], 'kode' => 'RJ03', 'nama' => 'Rasau Jaya II'],
            ['kecamatan_id' => $kecamatan['Rasau Jaya'], 'kode' => 'RJ04', 'nama' => 'Rasau Jaya III'],

            // =========================
            // KUALA MANDOR B
            // =========================
            ['kecamatan_id' => $kecamatan['Kuala Mandor B'], 'kode' => 'KMB01', 'nama' => 'Kuala Mandor B'],
            ['kecamatan_id' => $kecamatan['Kuala Mandor B'], 'kode' => 'KMB02', 'nama' => 'Mega Timur'],
            ['kecamatan_id' => $kecamatan['Kuala Mandor B'], 'kode' => 'KMB03', 'nama' => 'Retok'],
            ['kecamatan_id' => $kecamatan['Kuala Mandor B'], 'kode' => 'KMB04', 'nama' => 'Sungai Enau'],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desas');
    }
}
