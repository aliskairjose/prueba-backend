<?php

namespace App\Imports;

use App\Country;
use App\Http\Resources\Country as ResourcesCountry;
use App\Http\Resources\PaymentMethod as ResourcesPaymentMethod;
use App\Http\Resources\Product as ResourcesProduct;
use App\MyOrder;
use App\PaymentMethod;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

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
        $paymentMethod =  new ResourcesPaymentMethod(PaymentMethod::where('name', $row['Payment Method Title'])->get());
        $country =  new ResourcesCountry(Country::where('code', $row['Country Code (Shipping)'])->get());
        $product = new ResourcesProduct(Product::where('sku', $row['SKU'])->get());

        return new MyOrder(
            [
                'user_id'           => $user->id,
                'suplier_id'        => $product->user_id,
                'payment_method_id' => $paymentMethod->id,
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

            ]
        );
    }
}
