<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Connection;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
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
            DB::table('users')->insert(array(
                'name' => $faker->name,
                'surname' => $faker->lastName,
                'email' => $faker->email,
                'birthday'=>$faker->date,
                'type_user'=>$faker->randomElement(['suplier', 'dropshiper', 'administrador']),
                'status'=> $faker->randomElement(['Activo', 'Suspendido', 'Inactivo']),
                'password'=>$faker->password,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            ));
        }
    }
}
