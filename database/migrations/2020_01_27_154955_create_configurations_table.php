<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('smtp_host', 255)->nullable(true);
            $table->string('smtp_port', 255)->nullable(true);
            $table->string('smtp_username', 255)->nullable(true);
            $table->string('smtp_password', 255)->nullable(true);
            $table->string('smtp_encrption', 255)->nullable(true);
            $table->string('sender_email', 255)->nullable(true);
            $table->string('email_charset', 255)->nullable(true);
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
        Schema::dropIfExists('configurations');
    }
}
