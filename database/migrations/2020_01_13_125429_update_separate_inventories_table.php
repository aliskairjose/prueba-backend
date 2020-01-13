<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSeparateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('separate_inventories', function (Blueprint $table) {
            $table->decimal('quantity',18,2)->nullable();
            $table->integer('product_id')->unsigned()->index('separate_inventories_product_id')->nullable(false);
            $table->integer('variation_id')->unsigned()->index('separate_inventories_variation_id')->nullable(true);
            $table->dropColumn(['total']);
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
        Schema::table('separate_inventories', function (Blueprint $table) {
            $table->dropForeign(['separate_inventories_product_id']);
            $table->dropForeign(['separate_inventories_variation_id']);
            $table->dropColumn(['product_id']);
            $table->dropColumn(['variation_id']);
            $table->dropColumn(['quantity']);
            $table->decimal('total',18,2)->nullable();
        });
    }
}
