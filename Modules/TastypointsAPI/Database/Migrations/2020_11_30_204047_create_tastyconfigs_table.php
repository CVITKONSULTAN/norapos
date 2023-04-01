<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTastyconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tastyconfigs', function (Blueprint $table) {
            $table->bigIncrements('id');
           //$table->text("link")->default("https://tastypoints.io/akm/restapi.php");
	$table->text("link")->nullable();            
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
        Schema::dropIfExists('tastyconfigs');
    }
}
