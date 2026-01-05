<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewDatesToPpdbSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb_settings', function (Blueprint $table) {
            $table->date('tgl_tutup_penerimaan')->nullable()->after('tgl_penerimaan');
            $table->date('tgl_masuk_sekolah')->nullable()->after('tgl_tutup_penerimaan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppdb_settings', function (Blueprint $table) {
             $table->dropColumn(['tgl_tutup_penerimaan', 'tgl_masuk_sekolah']);
        });
    }
}
