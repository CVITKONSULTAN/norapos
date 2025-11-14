<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePpdbTestSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppdb_test_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_bayar')->unique();

            // Tes IQ
            $table->date('iq_date')->nullable();
            $table->time('iq_start_time')->nullable();
            $table->time('iq_end_time')->nullable();

            // Tes Pemetaan
            $table->date('map_date')->nullable();
            $table->time('map_start_time')->nullable();
            $table->time('map_end_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppdb_test_schedules');
    }
}
