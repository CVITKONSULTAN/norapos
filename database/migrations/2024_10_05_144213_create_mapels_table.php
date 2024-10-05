<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->enum('kategori',['mulok','wajib','pilihan']);
            $table->json('lingkup_materi')->nullable();
            $table->json('tujuan_pembelajaran')->nullable();

            $table->unsignedInteger('business_id');
            $table->foreign('business_id')
            ->references('id')->on('business')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapels');
    }
}
