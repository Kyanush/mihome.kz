<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function ($table) {
            $table->integer('attribute_group_id')->unsigned()->nullable();
            $table->foreign('attribute_group_id')->references('id')->on('attribute_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attributes', function($table) {
            $table->dropColumn('attributes');
        });
    }
}
