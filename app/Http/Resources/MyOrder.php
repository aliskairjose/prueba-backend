<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

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
          'user_name'         => $user->name. " " . $user->surname,
          'suplier_id'        => $this->suplier_id,
          'suplier_name'      => $supplier->name. " " . $supplier->surname,
          'payment_method_id' => $this->payment_method_id,
          'status'            => $this->status,
          'dir'               => $this->dir,
          'phone'             => $this->phone,
          'type'              => $this->type,
          'quantity'          => $this->quantity,
          'product_id'        => $this->product_id,
          'variation_id'      => $this->variation_id,
        //   'history'           => $this->records
        ];
    }
}
