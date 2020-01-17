<?php

namespace App\Http\Resources;

use App\AttributesValues;
use Illuminate\Http\Resources\Json\JsonResource;

class Attribute extends JsonResource
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
            'id'=>$this->id,
            'description'=>$this->description,
            'product_id'=>$this->product_id,
            'values' => new AttributeValueCollection($this->attributesValues),
        ];
    }
}
