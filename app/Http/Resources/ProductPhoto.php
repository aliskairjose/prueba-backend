<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPhoto extends JsonResource
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
            'url'           => $this->url,
            'main'          => $this->main,
            'product_id'    => $this->product_id,
            'variation_id'  => $this->variation_id
        ];
    }
}
