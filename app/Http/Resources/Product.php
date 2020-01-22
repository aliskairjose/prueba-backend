<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\Resource;

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
        $user = new Resource($this->user);
        return [
          'id'               => $this->id,
          'name'             => $this->name,
          'description'      => $this->description,
          'type'             => $this->type,
          'stock'            => $this->stock,
          'sale_price'       => $this->sale_price,
          'suggested_price'  => $this->suggested_price,
          'user_id'          => $this->user_id,
          'privated_product' => $this->privated_product,
          'active'           => $this->active,
          //          'approve_product'  => $user->approve_product,
          'attributes'       => new AttributeCollection($this->attributes),
          'variations'       => new VariationCollection($this->variations),
          'gallery'          => new ProductPhotoCollection($this->photos),
          'categories'       => new CategoryCollection($this->categories),
          'persistanceState' => 'Unchanged',
        ];
    }
}
