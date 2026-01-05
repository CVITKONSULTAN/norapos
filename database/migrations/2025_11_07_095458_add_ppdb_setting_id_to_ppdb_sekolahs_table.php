<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPpdbSettingIdToPpdbSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_p_d_b_sekolahs', function (Blueprint $table) {
             // Tambahkan kolom relasi ke PPDBSetting
            $table->unsignedBigInteger('ppdb_setting_id')->nullable()->after('id');

            // Optional: jika kamu mau buat foreign key-nya
            $table->foreign('ppdb_setting_id')
                ->references('id')->on('ppdb_settings')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_p_d_b_sekolahs', function (Blueprint $table) {
            $table->dropForeign(['ppdb_setting_id']);
            $table->dropColumn('ppdb_setting_id');
        });
    }
}
