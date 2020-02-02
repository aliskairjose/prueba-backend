<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_orders', function (Blueprint $table) {
            $table->decimal('price')->nullable()->default(0);
            $table->decimal('total_order')->nullable()->default(0);
            $table->text('notes')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('surname', 50)->nullable();
            $table->text('street_address')->nullable();
            $table->string('country', 50 )->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip_code', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
