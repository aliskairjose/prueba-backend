<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHistoryWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_wallets', function (Blueprint $table) {
            $table->text('payu_orderid')->nullable(true)->comment('cuando la transaccion sea parte 
            de un abono por Payu, se almacena el id de la transaccion aca');
        });
    }

    /**
     * Reverse the migrations.
     *N
     * @return void
     */
    public function down()
    {
        //
    }
}
