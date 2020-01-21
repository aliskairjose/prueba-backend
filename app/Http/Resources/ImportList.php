<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportList extends JsonResource
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
          'id'           => $this->id,
          'user_id'      => $this->user_id,
          'product_id'   => $this->product_id,
          'variation_id' => $this->variation_id,
          'products'     => new ProductCollection($this->products)
        ];
    }
}
