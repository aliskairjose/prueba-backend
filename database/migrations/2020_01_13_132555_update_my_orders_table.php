<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_orders', function (Blueprint $table) {
            $table->dropColumn(['total']);

            $table->string('type', 50)->nullable();
            $table->decimal('quantity',18,2)->nullable();
            $table->integer('product_id')->unsigned()->index('my_orders_product_id')->nullable(false);
            $table->integer('variation_id')->unsigned()->index('my_orders_variation_id')->nullable(true);

            $table->foreign('variation_id')->references('id')->on('variations');
            $table->foreign('product_id')->references('id')->on('products');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('separate_details', function (Blueprint $table) {
            $table->dropForeign(['my_orders_product_id']);
            $table->dropForeign(['my_orders_variation_id']);
            $table->dropColumn(['type']);
            $table->dropColumn(['quantity']);
            $table->dropColumn(['variation_id']);
            $table->dropColumn(['product_id']);
            $table->decimal('total',18,2)->nullable();
        });
    }
}
