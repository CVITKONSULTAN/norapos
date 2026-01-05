<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbgTrackingsTable extends Migration
{
    public function up()
    {
        Schema::create('pbg_trackings', function (Blueprint $table) {
            $table->bigIncrements('id');

            // ID Pengajuan PBG
            $table->unsignedBigInteger('pengajuan_id')->index();

            // Siapa yang melakukan verifikasi
            $table->unsignedInteger('user_id')->nullable()->index();

            // Role tahapan: admin_entry, petugas, pemeriksa, retribusi, koordinator, kabid
            $table->string('role', 50)->index();

            // Catatan tiap tahap
            $table->text('catatan')->nullable();

            // Status tahap: pending, approved, rejected
            $table->string('status', 20)->default('pending');

            // Waktu verifikasi
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            // Relasi opsional
            $table->foreign('pengajuan_id')->references('id')->on('pengajuan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pbg_trackings');
    }
}
