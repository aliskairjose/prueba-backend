<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_photos', function (Blueprint $table) {
           $table->integer('variation_id')->unsigned()->index('product_photos_variation_id')->nullable(true);
           $table->foreign('variation_id')->references('id')->on('variations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_photos', function (Blueprint $table) {
        $table->dropForeign(['product_photos_variation_id']);
        $table->dropColumn(['variation_id']);
        });
    }
}
