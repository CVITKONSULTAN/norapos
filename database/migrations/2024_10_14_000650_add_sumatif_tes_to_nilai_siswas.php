<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSumatifTesToNilaiSiswas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_siswas', function (Blueprint $table) {
            $table->integer('sumatif_tes')->default(0);
            $table->integer('sumatif_non_tes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_siswas', function (Blueprint $table) {
            //
        });
    }
}
