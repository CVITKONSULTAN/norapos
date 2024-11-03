<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEkskulSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekskul_siswas', function (Blueprint $table) {
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

            $table->unsignedBigInteger('ekskul_id');
            $table->foreign('ekskul_id')
            ->references('id')->on('ekstrakurikulers')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->text('keterangan')->nullable();

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
        Schema::dropIfExists('ekskul_siswas');
    }
}
