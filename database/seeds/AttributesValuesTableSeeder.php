<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class AttributesValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'S',
                'attribute_id' => 3,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'M',
                'attribute_id' => 3,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'L',
                'attribute_id' => 3,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'XL',
                'attribute_id' => 3,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'Rojo',
                'attribute_id' => 4,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'Negro',
                'attribute_id' => 4,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'Blanco',
                'attribute_id' => 4,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'Azul marino',
                'attribute_id' => 4,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'Lana',
                'attribute_id' => 5,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'Algodón',
                'attribute_id' => 5,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'Lino',
                'attribute_id' => 5,
            ]
        );
        DB::table('attribute_values')->updateOrInsert(
            [
                'value' => 'Seda',
                'attribute_id' => 5,
            ]
        );
    }
}
