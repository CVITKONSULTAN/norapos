<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationFieldsToPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            // Add notes field if not exists
            if (!Schema::hasColumn('pengajuan', 'notes')) {
                $table->text('notes')->nullable()->after('photoMaps');
            }
            
            // Add verified_at field if not exists
            if (!Schema::hasColumn('pengajuan', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('notes');
            }
            
            // Add verified_by field if not exists
            if (!Schema::hasColumn('pengajuan', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            }
            
            // Add petugas_id field if not exists
            if (!Schema::hasColumn('pengajuan', 'petugas_id')) {
                $table->unsignedBigInteger('petugas_id')->nullable()->after('petugas_lapangan');
            }
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
            $columns = ['notes', 'verified_at', 'verified_by', 'petugas_id'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('pengajuan', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
