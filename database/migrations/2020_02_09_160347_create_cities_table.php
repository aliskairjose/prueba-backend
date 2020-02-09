<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('department_id')->index('cities_department_id')->nullable(false);
            $table->text('name')->nullable();

            $table->text('rate_type')->nullable(true)->comment('tipo de tarifa, puede almacenar
             2 valores, si es CON RECAUDO o SIN RECAUDO o ambas. sera un string json');
            $table->string('trajectory_type', 100)->nullable(true)
                ->comment('NACIONAL,ZONAL,URBANO,TRAYECTO ESPECIAL');

            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::dropIfExists('cities');
    }
}
