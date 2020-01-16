<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeparateInventory extends JsonResource
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
          'id'              => $this->id,
          'user_id'         => $this->user_id,
          'suplier_id'      => $this->suplier_id,
          'quantity'        => $this->status,
          'product_id'      => $this->product_id,
          'variation_id'    => $this->variation_id,
        ];
    }
}
