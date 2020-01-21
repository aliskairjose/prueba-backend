<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
          'name'             => $this->name,
          'description'      => $this->description,
          'type'             => $this->type,
          'stock'            => $this->stock,
          'sale_price'       => $this->sale_price,
          'suggested_price'  => $this->suggested_price,
          'user_id'          => $this->user_id,
          'attributes'       => new AttributeCollection($this->attributes),
          'variations'       => new VariationCollection($this->variations),
          'gallery'          => new ProductPhotoCollection($this->photos),
          'categories'       => new CategoryCollection($this->categories),
          'persistanceState' => 'Unchanged',
        ];
    }
}
