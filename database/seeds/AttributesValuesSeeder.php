<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Connection;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AttributesValuesSeeder extends Seeder
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
            DB::table('attributes_values')->insert(array(
                'value' => $faker->name(),
                'attribute_id' => $faker->numberBetween(1, 6),
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            ));
        }
    }
}
