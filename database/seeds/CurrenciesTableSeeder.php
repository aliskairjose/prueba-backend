<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->updateOrInsert(
            [
                'name' => 'PESO COLOMBIANO',
                'code' => 'COP',
                'country_id' => 1,
            ]
        );
    }
}
