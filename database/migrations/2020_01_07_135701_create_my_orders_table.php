<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->index('rmy_orders_user_id')->nullable(false);
            $table->integer('suplier_id')->unsigned()->index('my_orders_suplier_id')->nullable(false);
            $table->integer('payment_method_id')->unsigned()->index('my_orders_payment_method_id')->nullable(true);
            $table->string('status', 100)->nullable();
            $table->decimal('total',18,2)->nullable();
            $table->text('dir')->nullable(true);
            $table->string('phone', 100)->nullable(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('suplier_id')->references('id')->on('users');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_orders');
    }
}
