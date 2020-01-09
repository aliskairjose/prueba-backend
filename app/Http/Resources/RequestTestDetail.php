<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestTestDetail extends JsonResource
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
          'request_test_id' => $this->request_test_id,
          'product_id'      => $this->product_id,
          'variation_id'    => $this->variation_id,
          'quantity'        => $this->quantity,
          'price'           => $this->price
        ];
    }
}
