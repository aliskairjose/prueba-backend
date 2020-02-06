<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayuTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payu_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->index('payu_transactions_user_id')->nullable(false);
            $table->text('paymentmethod')->nullable(true);
            $table->text('orderid')->nullable(true);
            $table->text('transactionid')->nullable(true);
            $table->text('state')->nullable(true);
            $table->text('responsecode')->nullable(true);

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('payu_transactions');
    }
}
