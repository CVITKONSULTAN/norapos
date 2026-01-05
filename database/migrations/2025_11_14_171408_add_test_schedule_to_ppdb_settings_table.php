<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddTestScheduleToPpdbSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb_settings', function (Blueprint $table) {
            $table->json('iq_days')->nullable();       // ["2025-02-19","2025-02-20","2025-02-21"]
            $table->json('map_days')->nullable();      // ["2025-02-26","2025-02-27","2025-02-28"]
            $table->json('sessions')->nullable();      // [["07:00","08:00"], ["08:00","09:00"], ...]
            $table->integer('capacity_per_session')->default(14);
        });

        // 🔥 Seeder default (jika baris sudah ada)
        $latest = DB::table('ppdb_settings')->orderBy('id', 'desc')->first();

        if ($latest) {
            DB::table('ppdb_settings')
                ->where('id', $latest->id)
                ->update([
                    'iq_days' => json_encode([
                        "2025-02-19",
                        "2025-02-20",
                        "2025-02-21",
                    ]),
                    'map_days' => json_encode([
                        "2025-02-26",
                        "2025-02-27",
                        "2025-02-28",
                    ]),
                    'sessions' => json_encode([
                        ["07:00", "08:00"],
                        ["08:00", "09:00"],
                        ["09:00", "10:00"],
                        ["10:00", "11:00"],
                        ["11:00", "12:00"],
                    ]),
                    'capacity_per_session' => 14,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppdb_settings', function (Blueprint $table) {
            //
        });
    }
}
