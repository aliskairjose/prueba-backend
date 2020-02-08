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
          'id'                  => $this->id,
          'user_id'             => $this->user_id,
          'product_id'          => $this->product_id,
          'variation_id'        => $this->variation_id,
          'imported_to_store'   => $this->importe_to_store,
          'date_imported_store' => $this->date_importe_store,
          'product_name'        => $this->product_name,
            'woocomerse_url'        => $this->woocomerse_url,
            'woocomerse_id'        => $this->woocomerse_id,
          'products'            => new ProductCollection($this->products)
        ];
    }
}
