<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeparateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('separate_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('separate_inventory_id')->unsigned()->index('separate_details_separate_inventory_id')->nullable(false);
            $table->integer('product_id')->unsigned()->index('separate_details_product_id')->nullable(false);
            $table->integer('variation_id')->unsigned()->index('separate_details_variation_id')->nullable(true);
            $table->decimal('quantity',18,2)->nullable();
            $table->decimal('price',18,2)->nullable();
            $table->foreign('separate_inventory_id')->references('id')->on('separate_inventories');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('variation_id')->references('id')->on('variations');
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
        Schema::dropIfExists('separate_details');
    }
}
