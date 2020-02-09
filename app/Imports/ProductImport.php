<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $user = Product::getAuthenticatedUser();
        return new Product(
            [
                'name'          => $row['TITLE'],
                'description'   => $row['DESCRIPTION'],
                'sku'           => $row['SKU'],
                'sale_price'    => $row['PRICE'],
                'weight'        => $row['WEIGHT'],
                'stock'         => $row['STOCK'],
                'width'         => $row['WIDTH'],
                'lenght'        => $row['LENGTH'],
                'height'        => $row['HEIGHT'],
                'user_id'       => $user->id

            ]
        );

        /* return new Product([
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
        ]); */
    }

}
