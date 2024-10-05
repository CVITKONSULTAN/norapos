<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_siswas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')
            ->references('id')->on('siswas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('kelas_id');
            $table->foreign('kelas_id')
            ->references('id')->on('kelas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('mapel_id');
            $table->foreign('mapel_id')
            ->references('id')->on('mapels')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->json('nilai_tp')->nullable();
            $table->integer('nilai_akhir_tp')->default(0);
            $table->json('nilai_sumatif')->nullable();
            $table->integer('nilai_akhir_sumatif')->default(0);
            $table->integer('nilai_rapor')->default(0);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_siswas');
    }
}
