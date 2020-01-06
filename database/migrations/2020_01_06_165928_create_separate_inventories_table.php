<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeparateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('separate_inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->index('separate_inventories_user_id')->nullable(false);
            $table->integer('suplier_id')->unsigned()->index('import_lists_suplier_id')->nullable(false);
            $table->string('status', 100)->nullable();
            $table->decimal('total',18,2)->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('suplier_id')->references('id')->on('users');
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
        Schema::dropIfExists('separate_inventories');
    }
}
