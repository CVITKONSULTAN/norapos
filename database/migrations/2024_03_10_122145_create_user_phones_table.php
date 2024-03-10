<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_phones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("uid");
            $table->string("fcmToken");
            $table->string("brand")->nullable();
            $table->string("osVersion")->nullable();
            $table->string("email")->nullable();
            $table->string("nohp")->nullable();
            $table->string("password")->nullable();
            $table->datetime("deleted_at")->nullable();
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
        Schema::dropIfExists('user_phones');
    }
}
