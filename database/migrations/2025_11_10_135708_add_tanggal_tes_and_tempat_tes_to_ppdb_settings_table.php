<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTanggalTesAndTempatTesToPpdbSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb_settings', function (Blueprint $table) {
            $table->date('tanggal_tes')->nullable()->after('updated_at');
            $table->string('tempat_tes')->nullable()->after('tanggal_tes');
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_settings', function (Blueprint $table) {
            $table->dropColumn(['tanggal_tes', 'tempat_tes']);
        });
    }
}
