<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentFieldsToPPDBSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_p_d_b_sekolahs', function (Blueprint $table) {
            $table->string('kode_bayar')->nullable()->after('nama');
            $table->enum('status_bayar', ['belum', 'sudah'])->default('belum')->after('kode_bayar');
            $table->string('bank_pembayaran')->nullable()->after('status_bayar');
            $table->json('bukti_pembayaran')->nullable()->after('bank_pembayaran');
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
            $table->dropColumn(['kode_bayar', 'status_bayar', 'bank_pembayaran', 'bukti_pembayaran']);
        });
    }
}
