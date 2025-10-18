<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetugasLapangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas_lapangans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('bidang')->default('ciptakarya');
            $table->string('jabatan')->nullable();
            $table->string('nip')->nullable();
            $table->string('nik')->nullable();
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
        Schema::dropIfExists('petugas_lapangans');
    }
}
