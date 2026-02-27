<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotaNameAndIngredientAliases extends Migration
{
    public function up()
    {
        // Tambah kolom nota_name di purchase lines
        Schema::table('ingredient_purchase_lines', function (Blueprint $table) {
            $table->string('nota_name')->nullable()->after('ingredient_id')
                ->comment('Nama asli dari struk/nota supplier');
        });

        // Tabel alias untuk mapping nama nota → ingredient
        Schema::create('ingredient_aliases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('ingredient_id');
            $table->string('alias_name');
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');

            // Satu alias unik per business
            $table->unique(['business_id', 'alias_name']);
            $table->index(['business_id', 'ingredient_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredient_aliases');

        Schema::table('ingredient_purchase_lines', function (Blueprint $table) {
            $table->dropColumn('nota_name');
        });
    }
}
