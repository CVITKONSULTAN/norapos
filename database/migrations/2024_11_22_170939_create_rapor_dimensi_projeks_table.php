<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaporDimensiProjeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor_dimensi_projeks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('rapor_projek_id');
            $table->foreign('rapor_projek_id')
            ->references('id')->on('rapor_projeks')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('dimensi_id');
            $table->text('dimensi_text');

            $table->json('subelemen_fase')->nullable();

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
        Schema::dropIfExists('rapor_dimensi_projeks');
    }
}
