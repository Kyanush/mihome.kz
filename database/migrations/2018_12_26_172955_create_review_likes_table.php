<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_likes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('like')->default(0);
            $table->string('visit_number', 255);

            $table->integer('review_id')->unsigned();
            $table->foreign('review_id')
                ->references('id')->on('reviews')
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
        Schema::dropIfExists('review_likes');
    }
}
