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
    }

}
