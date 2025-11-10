<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemaKokurikulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tema_kokurikulers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tema');
            $table->text('aspek_nilai');
            $table->json('dimensi_list')->nullable();
            $table->string('kelas');
            $table->string('tahun_ajaran');
            $table->string('semester');
            $table->json('history_apply')->nullable();
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
        Schema::dropIfExists('tema_kokurikulers');
    }
}
