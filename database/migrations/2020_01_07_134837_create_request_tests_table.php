<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->index('request_tests_user_id')->nullable(false);
            $table->integer('suplier_id')->unsigned()->index('request_tests_suplier_id')->nullable(false);
            $table->integer('payment_method_id')->unsigned()->index('request_tests_payment_method_id')->nullable(true);
            $table->string('status', 100)->nullable();
            $table->decimal('total',18,2)->nullable();
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
        Schema::dropIfExists('request_tests');
    }
}
