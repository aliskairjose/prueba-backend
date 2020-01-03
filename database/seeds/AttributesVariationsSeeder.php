<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Connection;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AttributesVariationsSeeder extends Seeder
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
            DB::table('attribute_variations')->insert(array(
                'variation_id' => $faker->numberBetween(1, 6),
                'attribute_value_id' => $faker->numberBetween(1, 6),
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            ));
        }
    }
}
