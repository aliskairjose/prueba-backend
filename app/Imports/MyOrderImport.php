<?php

namespace App\Imports;

use App\Country;
use App\MyOrder;
use App\PaymentMethod;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class MyOrderImport implements ToModel, WithHeadingRow
{
     /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $user = MyOrder::getAuthenticatedUser();
        $product = Product::where('sku', $row['SKU'])->get();
        $product = $product[0];
        $paymentMethod =  PaymentMethod::where('name', $row['Payment Method Title'])->get();
        $paymentMethod = $paymentMethod[0];
        $country =  Country::where('code', $row['Country Code (Shipping)'])->get();
        $country = $country[0];

        return new MyOrder(
            [
                'user_id'           => $user->id,
                'suplier_id'        => $product->user_id,
                'payment_method_id' => $paymentMethod->id,
                'product_id'        => $product->id,
                'name'              => $row['First Name (Shipping)'],
                'surname'           => $row['Last Name (Shipping)'],
                'street_address'    => $row['Address 1&2 (Shipping)'],
                'city'              => $row['City (Shipping)'],
                'total_order'       => $row['Order Total Amount'],
                'total_order'       => $row['Order Total Amount'],
                'zip_code'          => $row['Postcode (Shipping)'],
                'country'           => $country->name,
                'quantity'          => $row['Quantity'],
                'price'             => $row['Item Cost'],
                'type'              => 'FINAL_ORDER',
                'status'            => $row['Order Status'],
                'phone'             => $row['Phone (Billing)'],
            ]
        );

    }
}
