<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyOrderDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'my_order_id'   => $this->my_order_id,
            'product_id'    => $this->product_id,
            'variation_id'  => $this->variation_id,
            'quantity'      => $this->quantity,
            'price'         => $this->price,
        ];
    }
}
