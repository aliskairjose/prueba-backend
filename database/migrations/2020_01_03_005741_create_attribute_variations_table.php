<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_variations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('variation_id')->unsigned()->index('variation_id')->nullable(false);
            $table->integer('attribute_value_id')->unsigned()->index('attribute_value_id')->nullable(false);
            $table->foreign('variation_id')->references('id')->on('variations');
            $table->foreign('attribute_value_id')->references('id')->on('attributes_values');
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
        Schema::dropIfExists('attribute_variations');
    }
}
