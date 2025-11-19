<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSekolahActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sekolah_activities', function (Blueprint $table) {
            $table->bigIncrements('id');

             // user yang melakukan
            $table->unsignedBigInteger('user_id')->nullable()->index();

            // sekolah / business pemilik data
            $table->unsignedBigInteger('business_id')->nullable()->index();

            // modul (mapel, kelas, siswa, nilai, jurnal, ppdb, dsb)
            $table->string('module')->index();

            // aksi (apply, update, delete, import, reset, dll)
            $table->string('action')->index();

            // referensi data utama
            $table->unsignedBigInteger('reference_id')->nullable()->index();

            // nama model-nya (App\Models\Mapel)
            $table->string('reference_type')->nullable();

            // informasi extra (JSON)
            $table->json('payload')->nullable();

            // metadata optional
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();


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
        Schema::dropIfExists('sekolah_activities');
    }
}
