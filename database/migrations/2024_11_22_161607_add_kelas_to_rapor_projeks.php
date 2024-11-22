<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKelasToRaporProjeks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rapor_projeks', function (Blueprint $table) {
            if(!Schema::hasColumn('rapor_projeks', 'kelas'))
            $table->integer('kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rapor_projeks', function (Blueprint $table) {
            //
        });
    }
}
