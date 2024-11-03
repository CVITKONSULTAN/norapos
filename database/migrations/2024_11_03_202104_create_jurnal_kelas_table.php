<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurnalKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_kelas', function (Blueprint $table) {
            $table->bigIncrements('id');

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

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->json('jurnal');
            $table->date('tanggal');

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
        Schema::dropIfExists('jurnal_kelas');
    }
}
