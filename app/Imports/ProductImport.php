<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'description' => $row['description'],
            'type' => $row['type'],
            'stock' => $row['stock'],
            'sale_price' => $row['sale_price'],
            'suggested_price' => $row['suggested_price'],
            'user_id' => $row['user_id'],
            'privated_product' => $row['privated_product'],
            'active' => $row['active'],
            'sku' => $row['sku'],
            'weight' => $row['weight'],
            'length' => $row['length'],
            'width' => $row['width'],
            'height' => $row['height'],
        ]);
    }
}
