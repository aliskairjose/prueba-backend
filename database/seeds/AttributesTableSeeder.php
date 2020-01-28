<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attributes')->updateOrInsert(
            [
                'description' => 'Talla',
                'product_id' => 8,
            ]
        );

        DB::table('attributes')->updateOrInsert(
            [
                'description' => 'Color',
                'product_id' => 8,
            ]
        );

        DB::table('attributes')->updateOrInsert(
            [
                'description' => 'Tela',
                'product_id' => 8,
            ]
        );
    }
}
