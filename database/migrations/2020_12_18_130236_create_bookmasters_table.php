<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmasters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('publication_id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('writer_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('publication_id')->references('id')->on('publications');
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('writer_id')->references('id')->on('writers');
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
        Schema::dropIfExists('bookmasters');
    }
}
