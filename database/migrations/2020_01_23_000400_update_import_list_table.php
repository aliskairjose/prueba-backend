<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateImportListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_lists', function (Blueprint $table) {
            $table->boolean('imported_to_store')->default(0);
            $table->dateTime('date_imported_store')->useCurrent = true;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_lists', function (Blueprint $table) {
            $table->dropColumn(['imported_to_store']);
            $table->dropColumn(['date_imported_store']);
        });
    }
}
