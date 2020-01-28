<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProducts2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable(true);
            $table->decimal('weight',18,3)->nullable(true)->comment('en kilogramos');
            $table->decimal('length',18,2)->nullable(true)->comment('en centimetros');
            $table->decimal('width',18,2)->nullable(true)->comment('en centimetros');
            $table->decimal('height',18,2)->nullable(true)->comment('en centimetros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku']);
            $table->dropColumn(['weight']);
            $table->dropColumn(['length']);
            $table->dropColumn(['width']);
            $table->dropColumn(['height']);
        });

    }
}
