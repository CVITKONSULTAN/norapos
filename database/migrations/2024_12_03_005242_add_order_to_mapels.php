<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToMapels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mapels', function (Blueprint $table) {
            if(!Schema::hasColumn('mapels', 'orders'))
            $table->tinyInteger('orders')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mapels', function (Blueprint $table) {
            //
        });
    }
}
