<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'stock' => $this->stock,
            'sale_price' => $this->sale_price,
            'suggested_price' => $this->suggested_price,
            'id_user'=>$this->user_id,
            'persistanceState' => 'Unchanged',
        ];
    }
}
