<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapelLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapel_levels', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('kelas',[1,2,3,4,5,6]);

            $table->json('lingkup_materi')->nullable();
            $table->json('tujuan_pembelajaran')->nullable();

            $table->unsignedBigInteger('mapels_id');
            $table->foreign('mapels_id')
            ->references('id')->on('mapels')
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
        Schema::dropIfExists('mapel_levels');
    }
}
