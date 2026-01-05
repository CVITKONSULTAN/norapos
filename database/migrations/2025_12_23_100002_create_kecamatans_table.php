<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKecamatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode');
            $table->string('nama');
            $table->timestamps();
        });

        // =========================
        // SEEDER KECAMATAN
        // =========================
        DB::table('kecamatans')->insert([
            ['kode' => 'KBR01', 'nama' => 'Batu Ampar', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KBR02', 'nama' => 'Kubu', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KBR03', 'nama' => 'Terentang', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KBR04', 'nama' => 'Sungai Raya', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KBR05', 'nama' => 'Sungai Ambawang', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KBR06', 'nama' => 'Sungai Kakap', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KBR07', 'nama' => 'Teluk Pakedai', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KBR08', 'nama' => 'Rasau Jaya', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KBR09', 'nama' => 'Kuala Mandor B', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kecamatans');
    }
}
