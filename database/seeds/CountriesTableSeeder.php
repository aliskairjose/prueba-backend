<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->updateOrInsert(
            [
                'name' => 'COLOMBIA',
                'code' => 'CO',
            ]
        );
    }
}
