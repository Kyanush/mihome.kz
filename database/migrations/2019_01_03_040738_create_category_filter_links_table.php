<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryFilterLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_filter_links', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 255);
            $table->string('link', 255);

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('no action')
                ->onUpdate('no action');

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
        Schema::dropIfExists('category_filter_links');
    }
}
