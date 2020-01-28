<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Product;

class VariationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('variations')->updateOrInsert(
            [
                'product_id' => 8,
                'stock' => 10,
                'sale_price' => 30000,
                'suggested_price' => 50000,
            ]
        );
        DB::table('variations')->updateOrInsert(
            [
                'product_id' => 8,
                'stock' => 5,
                'sale_price' => 30000,
                'suggested_price' => 50000,
            ]
        );

        DB::table('variations')->updateOrInsert(
            [
                'product_id' => 8,
                'stock' => 5,
                'sale_price' => 30000,
                'suggested_price' => 45000,
            ]
        );

        DB::table('variations')->updateOrInsert(
            [
                'product_id' => 8,
                'stock' => 10,
                'sale_price' => 30000,
                'suggested_price' => 60000,
            ]
        );
    }
}
