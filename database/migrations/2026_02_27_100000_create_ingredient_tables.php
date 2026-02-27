<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientTables extends Migration
{
    public function up()
    {
        // 1. Bahan baku
        Schema::create('ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->string('name');
            $table->string('sku')->nullable();
            $table->unsignedInteger('unit_id')->nullable();
            $table->decimal('min_stock', 22, 4)->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by');
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        // 2. Stok bahan per lokasi
        Schema::create('ingredient_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ingredient_id');
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('location_id');
            $table->decimal('current_qty', 22, 4)->default(0);
            $table->timestamp('updated_at')->nullable();

            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('business_locations')->onDelete('cascade');

            $table->unique(['ingredient_id', 'location_id']);
        });

        // 3. Resep produk (komposisi bahan per produk)
        Schema::create('product_recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('variation_id')->nullable();
            $table->unsignedInteger('ingredient_id');
            $table->decimal('qty_per_unit', 22, 4);
            $table->unsignedInteger('unit_id')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
        });

        // 4. Log mutasi stok bahan
        Schema::create('ingredient_stock_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('ingredient_id');
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('transaction_id')->nullable();
            $table->unsignedInteger('transaction_sell_line_id')->nullable();
            $table->decimal('qty_change', 22, 4);
            $table->string('ref_type', 50)->comment('sale,adjustment,manual,transfer');
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('business_locations')->onDelete('cascade');

            $table->index(['ingredient_id', 'location_id']);
            $table->index(['transaction_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredient_stock_logs');
        Schema::dropIfExists('product_recipes');
        Schema::dropIfExists('ingredient_stocks');
        Schema::dropIfExists('ingredients');
    }
}
