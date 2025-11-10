<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDimensiKokurikulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimensi_kokurikulers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('profil');
            $table->timestamps();
        });
        // 🧩 Insert default setting langsung setelah tabel dibuat
        $insert = [
            ['profil'=>'Keimanan dan ketaqwaan kepada Tuhan YME'],
            ['profil'=>'Kewargaan'],
            ['profil'=>'Penalaran kritis'],
            ['profil'=>'Kreativitas'],
            ['profil'=>'Kolaborasi'],
            ['profil'=>'Kemandirian'],
            ['profil'=>'Kesehatan'],
            ['profil'=>'Komunikasi']
        ];
        DB::table('dimensi_kokurikulers')->insert($insert);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dimensi_kokurikulers');
    }
}
