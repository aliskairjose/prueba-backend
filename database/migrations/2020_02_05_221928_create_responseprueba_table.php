<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsepruebaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responseprueba', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('responseprueba')->nullable(false)->comment('tabla de prueba para verificar el response de payu.
            se eliminara luego');
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
        Schema::dropIfExists('responseprueba');
    }
}
