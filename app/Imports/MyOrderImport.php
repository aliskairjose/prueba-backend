<?php

namespace App\Imports;

use App\MyOrder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MyOrderImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MyOrder::create([
              'user_id'           => $row[ 'user_id' ],
              'suplier_id'        => $row[ 'suplier_id' ],
              'payment_method_id' => $row[ 'payment_method_id' ],
              'status'            => $row[ 'status' ],
              'dir'               => $row[ 'dir' ],
              'phone'             => $row[ 'phone' ],
              'type'              => $row[ 'type' ],
              'quantity'          => $row[ 'quantity' ],
              'product_id'        => $row[ 'product_id' ],
              'variation_id'      => $row[ 'variation_id' ],
              'price'             => $row[ 'price' ],
              'total_order'       => $row[ 'total_order' ],
              'notes'             => $row[ 'notes' ],
              'name'              => $row[ 'name' ],
              'surname'           => $row[ 'surname' ],
              'street_address'    => $row[ 'street_address' ],
              'country'           => $row[ 'country' ],
              'state'             => $row[ 'state' ],
              'city'              => $row[ 'city' ],
              'zip_code'          => $row[ 'zip_code' ],
            ]);
        }
    }
}
