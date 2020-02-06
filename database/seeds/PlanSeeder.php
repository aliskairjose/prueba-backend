<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('subscription_plans')->updateOrInsert(
          [
            'name' => 'Free',
            'description' => 'Sin descripcion',
            'active' => true,
            'auto_manage_delivery' => false,
            'type' => 'DROPSHIPPER',
          ]
        );
    }
}
