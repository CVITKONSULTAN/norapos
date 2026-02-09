<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimbgSyncLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simbg_sync_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('synced_at')->useCurrent()->comment('Waktu sync dilakukan');
            $table->integer('total_fetched')->default(0)->comment('Total data yang diambil dari SIMBG');
            $table->integer('total_new')->default(0)->comment('Total data baru yang ditambahkan');
            $table->integer('total_updated')->default(0)->comment('Total data yang diupdate');
            $table->integer('total_skipped')->default(0)->comment('Total data yang di-skip');
            $table->enum('status', ['success', 'failed', 'partial'])->default('success')->comment('Status sync');
            $table->text('error_message')->nullable()->comment('Pesan error jika ada');
            $table->unsignedInteger('synced_by')->nullable()->comment('User ID yang trigger sync');
            $table->text('new_pengajuan_ids')->nullable()->comment('JSON array ID pengajuan baru');
            $table->timestamps();
            
            $table->foreign('synced_by')->references('id')->on('users')->onDelete('set null');
            $table->index('synced_at');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simbg_sync_logs');
    }
}
