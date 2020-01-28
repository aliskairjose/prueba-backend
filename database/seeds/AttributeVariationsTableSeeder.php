<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AttributeVariationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 8,
                'variation_id' => 1,
            ]
        );
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 12,
                'variation_id' => 1,
            ]
        );
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 16,
                'variation_id' => 1,
            ]
        );
        //////
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 7,
                'variation_id' => 2,
            ]
        );
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 11,
                'variation_id' => 2,
            ]
        );
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 15,
                'variation_id' => 2,
            ]
        );

        //////
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 6,
                'variation_id' => 3,
            ]
        );
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 10,
                'variation_id' => 3,
            ]
        );
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 14,
                'variation_id' => 3,
            ]
        );

        //////
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 6,
                'variation_id' => 4,
            ]
        );
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 10,
                'variation_id' => 4,
            ]
        );
        DB::table('attribute_variations')->updateOrInsert(
            [
                'attribute_value_id' => 16,
                'variation_id' => 4,
            ]
        );

    }
}
