<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->updateOrInsert(
            [
                'name' => 'Camisa de caballero DAS',
                'description' => 'nueva camisa de caballero con distintas variantes',
                'type'  => 'VARIABLE',
                'stock' => 30,
                'sale_price' => 30000,
                'suggested_price' => 50000,
                'user_id' => 1,
                'active'=>true
            ]
        );
        DB::table('products')->updateOrInsert(
            [
                'name' => 'Cama de gato',
                'description' => 'Cama de gato de algodon',
                'type'  => 'SIMPLE',
                'stock' => 20,
                'sale_price' => 20000,
                'suggested_price' => 28000,
                'user_id' => 1,
                'active'=>true
            ]
        );
    }
}
