<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_orders', function (Blueprint $table) {
            $table->integer('comission_percent')->nullable(true)->comment('porcentaje de la comision');
            $table->decimal('comission_amount', 10, 2)->nullable(true)
                  ->comment('Monto de la comision para la plataforma');
            $table->decimal('dropshipper_amount', 10, 2)->nullable(true)
                  ->comment('Monto para para la dropshipper');
            $table->decimal('supplier_amount', 10, 2)->nullable(true)
                  ->comment('Monto para para la supplier');

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
