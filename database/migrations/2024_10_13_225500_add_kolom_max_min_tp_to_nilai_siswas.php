<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKolomMaxMinTpToNilaiSiswas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_siswas', function (Blueprint $table) {
            $table->char("kolom_max_tp",1)->nullable();
            $table->integer("nilai_max_tp")->default(0);
            $table->text("catatan_max_tp")->nullable();
            $table->char("kolom_min_tp",1)->nullable();
            $table->integer("nilai_min_tp")->default(0);
            $table->text("catatan_min_tp")->nullable();
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
