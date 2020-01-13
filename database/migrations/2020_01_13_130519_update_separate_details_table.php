<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSeparateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('separate_details', function (Blueprint $table) {
            $table->dropForeign(['separate_inventory_id']);
            $table->dropColumn(['separate_inventory_id']);
            $table->dropColumn(['price']);

            $table->integer('payment_method_id')->unsigned()->index('separate_details_payment_method_id')->nullable(true);
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->decimal('total',18,2)->nullable();
            $table->string('status', 50)->nullable();
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
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn(['total']);
            $table->dropColumn(['status']);

            $table->integer('separate_inventory_id')->unsigned()->index('separate_details_separate_inventory_id')->nullable(false);
            $table->foreign('separate_inventory_id')->references('id')->on('separate_inventories');
            $table->decimal('price',18,2)->nullable();
        });
    }
}
