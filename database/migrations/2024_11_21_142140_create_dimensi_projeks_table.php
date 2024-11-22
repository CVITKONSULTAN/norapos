<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimensiProjeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimensi_projeks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('dimensi_id')->nullable();
            $table->foreign('dimensi_id')
            ->references('id')->on('data_dimensi_i_d_s')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            // $table->text('dimensi');
            $table->text('elemen');
            // $table->json('subelemen')->nullable();
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
        Schema::dropIfExists('dimensi_projeks');
    }
}
