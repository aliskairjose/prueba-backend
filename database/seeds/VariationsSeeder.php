<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Connection;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class VariationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 6; $i++) {
            DB::table('variations')->insert(array(
                'suggested_price' => $faker->randomDigit,
                'sale_price' => $faker->randomDigit,
                'product_id' => $faker->numberBetween(1, 6),
                'stock' => $faker->randomDigit,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            ));
        }
    }
}
