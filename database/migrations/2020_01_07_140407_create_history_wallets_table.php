<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('wallet_id')->unsigned()->index('history_wallets_wallet_id')->nullable(false);
            $table->decimal('amount',18,2)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('type', 100)->nullable();
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
        Schema::dropIfExists('history_wallets');
    }
}
