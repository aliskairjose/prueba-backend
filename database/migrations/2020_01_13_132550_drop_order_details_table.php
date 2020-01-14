<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('order_details');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('my_order_id')->unsigned()->index('order_details_my_order_id')->nullable(false);
            $table->integer('product_id')->unsigned()->index('order_details_details_product_id')->nullable(false);
            $table->integer('variation_id')->unsigned()->index('order_details_details_variation_id')->nullable(true);
            $table->decimal('quantity',18,2)->nullable();
            $table->decimal('price',18,2)->nullable();
            $table->foreign('my_order_id')->references('id')->on('my_orders');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('variation_id')->references('id')->on('variations');
            $table->timestamps();
        });
    }
}
