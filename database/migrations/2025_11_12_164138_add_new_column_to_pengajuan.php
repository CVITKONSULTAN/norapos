<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnToPengajuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('ketinggian_bangunan')->nullable();
            $table->string('koefisiensi_dasar')->nullable();
            $table->string('koefisiensi_lantai')->nullable();
            $table->string('koordinat_bangunan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn([
                'ketinggian_bangunan',
                'koefisiensi_dasar',
                'koefisiensi_lantai',
                'koordinat_bangunan',
            ]);
        });
    }
}
