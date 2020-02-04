<?php

namespace App\Http\Resources;

use App\Product;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MyOrder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $supplier = User::findOrFail($this->suplier_id);
        $user = User::findOrFail($this->user_id);

        return [
          'id'                => $this->id,
          'user_id'           => $this->user_id,
          'user_name'         => $user->name." ".$user->surname,
          'type_user'         => $user->type_user,
          'suplier_id'        => $this->suplier_id,
          'suplier_name'      => $supplier->name." ".$supplier->surname,
          'payment_method_id' => $this->payment_method_id,
          'status'            => $this->status,
          'dir'               => $this->dir,
          'phone'             => $this->phone,
          'type'              => $this->type,
          'quantity'          => $this->quantity,
          'product_id'        => $this->product_id,
          'product'           => Product::findOrFail($this->product_id),
          'variation_id'      => $this->variation_id,
          'price'             => $this->price,
          'total_order'       => $this->total_order,
          'notes'             => $this->notes,
          'name'              => $this->name,
          'surname'           => $this->surnae,
          'street_address'    => $this->street_address,
          'country'           => $this->country,
          'state'             => $this->state,
          'city'              => $this->city,
          'zip_code'          => $this->zip_code,
          'created_at'        => $this->created_at,
          'updated_at'        => $this->updated_at,
          //   'history'           => $this->records
        ];
    }
}
