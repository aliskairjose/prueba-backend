<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trajectories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('from',18,2)->nullable()->comment('peso en kmilogramos');
            $table->decimal('until',18,2)->nullable()->comment('peso en kmilogramos');
            $table->decimal('price',18,2)->nullable();
            $table->text('rate_type')->nullable(true)->comment('tipo de tarifa, puede almacenar
             2 valores, si es CON RECAUDO o SIN RECAUDO');
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
        Schema::dropIfExists('trajectories');
    }
}
