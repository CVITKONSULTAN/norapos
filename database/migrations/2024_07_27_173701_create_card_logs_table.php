<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_logs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string("user_id");
            $table->string("token");
            $table->string("nama");
            $table->date("checkin");
            $table->date("checkout");
            $table->integer("product_id");

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
        Schema::dropIfExists('card_logs');
    }
}
