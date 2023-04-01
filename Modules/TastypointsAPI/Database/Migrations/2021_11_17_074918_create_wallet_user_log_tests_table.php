<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletUserLogTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_user_log_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("slug");
            $table->string("id_payment");
            $table->biginteger("user_id");
            $table->string("type");
            $table->string("origin");
            $table->text("response");
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
        Schema::dropIfExists('wallet_user_log_tests');
    }
}
