<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMagicLinkToPetugasLapangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petugas_lapangans', function (Blueprint $table) {
            $table->string('magic_link_token', 64)->nullable()->after('auth_token');
            $table->timestamp('magic_link_expires_at')->nullable()->after('magic_link_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petugas_lapangans', function (Blueprint $table) {
            $table->dropColumn(['magic_link_token', 'magic_link_expires_at']);
        });
    }
}
