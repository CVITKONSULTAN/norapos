<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenueBookingIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('venue_booking_ingredients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('venue_booking_id');
            $table->unsignedInteger('ingredient_id');
            $table->unsignedInteger('unit_id')->nullable();
            $table->decimal('qty', 22, 4)->default(0);
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('venue_booking_id')->references('id')->on('venue_bookings')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('venue_booking_ingredients');
    }
}
