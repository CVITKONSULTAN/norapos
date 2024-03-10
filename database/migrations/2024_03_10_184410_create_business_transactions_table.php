<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status',[
                'menunggu pembayaran',
                'proses',
                'selesai',
                'batal'
            ])->default('menunggu pembayaran');

            $table->unsignedBigInteger('user_phones_id');
 
            $table->foreign('user_phones_id')
            ->references('id')
            ->on('user_phones')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->longtext('metadata');
            $table->string('category');
            $table->text('title');

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
        Schema::dropIfExists('business_transactions');
    }
}
