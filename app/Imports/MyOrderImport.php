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
              'user_id'           => $row[ 0 ],
              'suplier_id'        => $row[ 1 ],
              'payment_method_id' => $row[ 2 ],
              'status'            => $row[ 3 ],
              'dir'               => $row[ 4 ],
              'phone'             => $row[ 5 ],
              'type'              => $row[ 6 ],
              'quantity'          => $row[ 7 ],
              'product_id'        => $row[ 8 ],
              'variation_id'      => $row[ 9 ],
              'price'             => $row[ 10 ],
              'total_order'       => $row[ 11 ],
              'notes'             => $row[ 12 ],
              'name'              => $row[ 13 ],
              'surname'           => $row[ 14 ],
              'street_address'    => $row[ 15 ],
              'country'           => $row[ 16 ],
              'state'             => $row[ 17 ],
              'city'              => $row[ 18 ],
              'zip_code'          => $row[ 19 ],
            ]);
        }
    }
}
