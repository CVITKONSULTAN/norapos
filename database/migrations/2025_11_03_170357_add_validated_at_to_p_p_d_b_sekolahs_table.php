<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValidatedAtToPPDBSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('p_p_d_b_sekolahs', function (Blueprint $table) {
            $table->unsignedInteger('validated_by')->nullable()->after('status_bayar');
            $table->foreign('validated_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamp('validated_at')->nullable()->after('validated_by');
        });
    }

    public function down(): void
    {
        Schema::table('p_p_d_b_sekolahs', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn('validated_by');
            $table->dropColumn('validated_at');
        });
    }
}
