<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_test_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('request_test_id')->unsigned()->index('request_test_details_request_test_id')->nullable(false);
            $table->integer('product_id')->unsigned()->index('request_test_details_product_id')->nullable(false);
            $table->integer('variation_id')->unsigned()->index('request_test_details_variation_id')->nullable(true);
            $table->decimal('quantity',18,2)->nullable();
            $table->decimal('price',18,2)->nullable();
            $table->foreign('request_test_id')->references('id')->on('request_tests');
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
        Schema::dropIfExists('request_test_details');
    }
}
