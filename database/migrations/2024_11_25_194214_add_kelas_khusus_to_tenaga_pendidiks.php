<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKelasKhususToTenagaPendidiks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenaga_pendidiks', function (Blueprint $table) {
            if(!Schema::hasColumn('tenaga_pendidiks', 'kelas_khusus'))
            $table->json('kelas_khusus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenaga_pendidiks', function (Blueprint $table) {
            //
        });
    }
}
