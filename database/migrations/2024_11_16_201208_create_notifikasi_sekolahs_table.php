<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifikasiSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasi_sekolahs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('warna');
            $table->string('tipe');
            $table->string('judul');
            $table->string('deskripsi')->nullable();

            $table->json('data')
            ->nullable();

            $table->timestamp('read_at')->nullable();

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
        Schema::dropIfExists('notifikasi_sekolahs');
    }
}
