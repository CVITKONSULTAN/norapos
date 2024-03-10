<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('business_name')->nullable();
            $table->string('domain')->nullable();
            $table->longtext('details')->nullable();
            $table->datetime('expired_at')->nullable();
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
        Schema::dropIfExists('business_domains');
    }
}
