<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSimbgFieldsToPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('uid')->nullable()->unique()->after('id')->comment('UID from SIMBG');
            $table->timestamp('simbg_synced_at')->nullable()->after('updated_at')->comment('Last sync timestamp from SIMBG');
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
            $table->dropColumn(['uid', 'simbg_synced_at']);
        });
    }
}
