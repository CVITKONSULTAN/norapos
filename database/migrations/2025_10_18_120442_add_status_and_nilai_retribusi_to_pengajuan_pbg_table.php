<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndNilaiRetribusiToPengajuanPbgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('uploaded_files'); // atau posisi lain sesuai kebutuhan
            $table->decimal('nilai_retribusi', 20, 2)->nullable()->after('status'); // 15 digit total, 2 angka di belakang koma
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn(['status', 'nilai_retribusi']);
        });
    }
}
