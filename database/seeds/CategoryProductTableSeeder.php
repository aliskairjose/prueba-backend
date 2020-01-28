<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_product')->updateOrInsert(
            [
                'category_id' => 6,
                'product_id' => 8,
            ]
        );
        DB::table('category_product')->updateOrInsert(
            [
                'category_id' => 2,
                'product_id' => 9,
            ]
        );
    }
}
