<?php

use Illuminate\Database\Seeder;

class SubsciptionPlanSeeder extends Seeder
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
            'name' => 'Full Filmed',
            'description' => 'Dropi maneja los productos en bodega y controla la logistica de envios',
            'active' => true,
            'auto_manage_delivery' => false,
            'type' => 'SUPPLIER',
          ]
        );
    }
}
