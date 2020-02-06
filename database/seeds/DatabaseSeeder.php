<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call('UserSeeder');
        // $this->call('ProductSeeder');
        // $this->call('VariationsSeeder');
        // $this->call('AttributesSeeder');
        // $this->call('AttributesValuesSeeder');
        // $this->call('AttributesVariationsSeeder');
        // $this->call('SeparateInventorySeeder');
         $this->call('RolesTableSeeder');
        $this->call('CountriesTableSeeder');
        $this->call('CurrenciesTableSeeder');

    }
}
