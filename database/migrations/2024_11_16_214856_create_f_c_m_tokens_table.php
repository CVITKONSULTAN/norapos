<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFCMTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_c_m_tokens', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->text('token')->nullable();
            $table->json('devices')->nullable();

            $table->unsignedInteger('business_id')->nullable();
            $table->foreign('business_id')
            ->references('id')->on('business')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
            ->references('id')->on('users')
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
        Schema::dropIfExists('f_c_m_tokens');
    }
}
