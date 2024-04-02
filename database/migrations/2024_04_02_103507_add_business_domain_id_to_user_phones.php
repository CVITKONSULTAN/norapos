<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusinessDomainIdToUserPhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_phones', function (Blueprint $table) {
            $table->unsignedBigInteger('business_domain_id')->nullable();
 
            $table->foreign('business_domain_id')
            ->references('id')
            ->on('business_domains')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_phones', function (Blueprint $table) {
            //
        });
    }
}
