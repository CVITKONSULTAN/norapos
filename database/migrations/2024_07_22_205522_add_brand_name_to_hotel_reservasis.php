<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrandNameToHotelReservasis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_reservasis', function (Blueprint $table) {
            $table->text("metode_pembayaran")->nullable();
            $table->text("brand_name")->nullable();
            $table->integer("brand_id")->nullable();
            $table->integer("deposit")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_reservasis', function (Blueprint $table) {
            //
        });
    }
}
