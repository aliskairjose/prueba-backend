<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryOrder extends JsonResource
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
          'user_id'  => $this->user_id,
          'order_id' => $this->order_id,
          'status'   => $this->status,
          'shipping' => $this->shipping
        ];
    }
}
