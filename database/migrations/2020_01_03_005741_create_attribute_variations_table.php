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
            $table->unsignedInteger('variation_id')->nullable(false);
            $table->unsignedInteger('attribute_value_id')->nullable(false);
            $table->foreign('variation_id')->references('id')->on('variations');
            $table->foreign('attribute_value_id')->references('id')->on('attributes_values');
            $table->index('attribute_value_id');
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
