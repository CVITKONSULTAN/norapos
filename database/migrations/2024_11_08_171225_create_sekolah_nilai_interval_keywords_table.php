<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSekolahNilaiIntervalKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_interval_keywords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('nilai_minimum',5,2)->default(0);
            $table->decimal('nilai_maksimum',5,2)->default(0);
            $table->text('formatter_string');
            $table->enum('tipe',['terendah','tertinggi']);
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
        Schema::dropIfExists('nilai_interval_keywords');
    }
}
