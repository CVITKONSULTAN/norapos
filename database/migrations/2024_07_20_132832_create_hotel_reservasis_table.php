<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelReservasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_reservasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('harga')->default(0);
            $table->date('checkin');
            $table->date('checkout');
            $table->integer('durasi')->Default(1);

            $table->unsignedInteger('contact_id');
 
            $table->foreign('contact_id')
            ->references('id')
            ->on('contacts')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
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
        Schema::dropIfExists('hotel_reservasis');
    }
}
