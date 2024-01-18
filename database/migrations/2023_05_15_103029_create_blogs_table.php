<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->text("title");
            $table->string("slug");
            $table->longtext("description")->nullable();
            $table->text("default_image")->nullable();
            $table->string("language")->default("id");
            $table->enum("type",["draft","published"])->default("draft");
            $table->datetime("published_at")->nullable();

            $table->integer('user_id')->unsigned();
            $table->integer('business_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
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
        Schema::dropIfExists('blogs');
    }
}
