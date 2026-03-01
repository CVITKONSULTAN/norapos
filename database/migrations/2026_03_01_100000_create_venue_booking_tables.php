<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenueBookingTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Venues master table
        Schema::create('venues', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('capacity')->nullable()->comment('Max guest capacity');
            $table->decimal('base_price', 22, 4)->default(0)->comment('Default rental price');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // 2. Venue Bookings (main booking / event)
        Schema::create('venue_bookings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->string('booking_ref')->unique()->comment('Auto-generated booking reference');
            $table->unsignedInteger('venue_id');
            $table->unsignedInteger('contact_id')->nullable()->comment('Guest / customer from contacts');

            // Guest / customer info (quick fill jika belum ada di contacts)
            $table->string('guest_name');
            $table->string('guest_phone')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_company')->nullable()->comment('Instansi / perusahaan');

            // Event details
            $table->string('event_name')->nullable()->comment('Nama acara');
            $table->date('event_date');
            $table->time('event_start_time')->nullable();
            $table->time('event_end_time')->nullable();
            $table->integer('estimated_guests')->default(0)->comment('Perkiraan jumlah tamu');

            // PIC / Penanggung Jawab
            $table->string('pic_name')->nullable()->comment('Nama penanggung jawab');
            $table->string('pic_phone')->nullable();

            // Pricing
            $table->enum('pricing_type', ['per_pax', 'paket', 'custom'])->default('custom')->comment('Tipe harga: per pax, paket, atau custom');
            $table->decimal('price_per_pax', 22, 4)->default(0)->comment('Harga per orang jika per_pax');
            $table->decimal('total_amount', 22, 4)->default(0)->comment('Total keseluruhan');
            $table->decimal('dp_amount', 22, 4)->default(0)->comment('Jumlah DP yang dibayar');
            $table->decimal('remaining_amount', 22, 4)->default(0)->comment('Sisa yang belum dibayar');

            // Status
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable()->comment('Catatan tambahan / hasil negosiasi');

            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // 3. Venue Booking Items (menu / item yang dipesan)
        Schema::create('venue_booking_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('venue_booking_id');
            $table->string('item_name')->comment('Nama menu / item pesanan');
            $table->decimal('quantity', 22, 4)->default(1);
            $table->string('unit')->nullable()->comment('pax, porsi, paket, dll');
            $table->decimal('price', 22, 4)->default(0)->comment('Harga satuan');
            $table->decimal('subtotal', 22, 4)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('venue_booking_id')->references('id')->on('venue_bookings')->onDelete('cascade');
        });

        // 4. Venue Booking Payments (riwayat pembayaran / DP)
        Schema::create('venue_booking_payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('venue_booking_id');
            $table->decimal('amount', 22, 4)->default(0);
            $table->enum('method', ['cash', 'transfer', 'card', 'other'])->default('cash');
            $table->string('payment_ref')->nullable()->comment('No referensi / bukti transfer');
            $table->text('note')->nullable();
            $table->date('paid_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('venue_booking_id')->references('id')->on('venue_bookings')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('venue_booking_payments');
        Schema::dropIfExists('venue_booking_items');
        Schema::dropIfExists('venue_bookings');
        Schema::dropIfExists('venues');
    }
}
