<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientPurchaseTables extends Migration
{
    public function up()
    {
        // Pembelian/penerimaan bahan batch
        Schema::create('ingredient_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('contact_id')->nullable()->comment('Supplier');
            $table->string('ref_no')->nullable()->comment('Nomor referensi');
            $table->date('purchase_date');
            $table->text('notes')->nullable();
            $table->enum('status', ['received', 'pending'])->default('received');
            $table->unsignedInteger('created_by');
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('business_locations')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        // Detail baris per bahan
        Schema::create('ingredient_purchase_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ingredient_purchase_id');
            $table->unsignedInteger('ingredient_id');
            $table->decimal('quantity', 22, 4);
            $table->decimal('unit_price', 22, 4)->default(0)->comment('Harga satuan');
            $table->decimal('total_price', 22, 4)->default(0);
            $table->timestamps();

            $table->foreign('ingredient_purchase_id')->references('id')->on('ingredient_purchases')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredient_purchase_lines');
        Schema::dropIfExists('ingredient_purchases');
    }
}
