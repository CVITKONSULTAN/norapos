<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsDetailsToUserPhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_phones', function (Blueprint $table) {
            $table->text('name')->nullable();
            $table->string('ktp')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota_kab')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->text('alamat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('user_phones', function (Blueprint $table) {
            //
        // });
    }
}
