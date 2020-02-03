<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductCollection;

class LandingPage extends JsonResource
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
          'id'         => $this->id,
          'user_id'    => $this->user_id,
          'product_id' => $this->product_id,
          'url'        => $this->url,
          'product'    => new ProductCollection($this->product)
        ];
    }
}
