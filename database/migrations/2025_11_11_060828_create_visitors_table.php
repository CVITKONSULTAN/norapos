<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address', 45)->index();
            $table->string('user_agent')->nullable();
            $table->string('page')->nullable();
            $table->date('visited_date')->index();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('visitors');
    }
}
