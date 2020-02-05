<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->updateOrInsert(
            [
                'name' => 'ADMIN',
                'guard_name' => 'ADMIN'
            ]
        );
        DB::table('roles')->updateOrInsert(
            [
                'name' => 'DROPSHIPPER',
                'guard_name' => 'DROPSHIPPER'
            ]
        );
        DB::table('roles')->updateOrInsert(
            [
                'name' => 'SUPPLIER',
                'guard_name' => 'SUPPLIER'
            ]
        );
    }
}
