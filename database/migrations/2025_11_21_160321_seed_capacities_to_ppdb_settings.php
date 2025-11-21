<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCapacitiesToPpdbSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         // =============================
        //  SEEDER UNTUK SESSION BARU
        // =============================

        $iqDays = [
            "2026-02-09",
            "2026-02-10",
            "2026-02-11",
        ];

        $mapDays = [
            "2026-02-12",
            "2026-02-13",
            "2026-02-14",
        ];

        $sessions = [
            ["07:00", "08:00"],
            ["08:00", "09:00"],
            ["09:00", "10:00"],
            ["10:00", "11:00"],
            ["11:00", "12:00"],
        ];

        $capacity = 14;
        $result = [];

        // IQ Sessions
        foreach ($iqDays as $day) {
            foreach ($sessions as $s) {
                $result[] = [
                    "type"     => "iq",
                    "date"     => $day,
                    "start"    => $s[0],
                    "end"      => $s[1],
                    "capacity" => $capacity,
                ];
            }
        }

        // MAP Sessions
        foreach ($mapDays as $day) {
            foreach ($sessions as $s) {
                $result[] = [
                    "type"     => "map",
                    "date"     => $day,
                    "start"    => $s[0],
                    "end"      => $s[1],
                    "capacity" => $capacity,
                ];
            }
        }

        // Simpan hanya ke PPDBSetting yang paling baru
        \App\Models\Sekolah\PPDBSetting::orderBy('id','desc')->first()
            ->update([
                "session_capacities" => $result
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
