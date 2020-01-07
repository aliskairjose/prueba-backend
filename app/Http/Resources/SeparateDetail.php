<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeparateDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'separate_inventory_id' => $this->separate_inventory_id,
          'product_id'            => $this->product_id,
          'variation_id'          => $this->variation_id,
          'quantity'              => $this->quantity,
          'price'                 => $this->price
        ];
    }
}
