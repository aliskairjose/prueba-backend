<?php

namespace App\Http\Resources;

use App\AttributesValues;
use App\AttributeVariation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Variation extends JsonResource
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
          'id'               => $this->id,
          'suggested_price'  => $this->suggested_price,
          'sale_price'       => $this->sale_price,
          'product_id'       => $this->product_id,
          'stock'            => $this->stock,
//          'attributes_value' => $this->attributeValues,
          'attributes_value' => new AttributeValueCollection($this->attributeValues),
        ];
    }
}
