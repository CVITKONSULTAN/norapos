<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaseDimensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fase_dimensis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('subelemen_index');
            $table->text('keterangan');

            $table->unsignedBigInteger('elemen_id')->nullable();
            $table->foreign('elemen_id')
            ->references('id')->on('dimensi_projeks')
            ->onDelete('cascade')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('fase_dimensis');
    }
}
