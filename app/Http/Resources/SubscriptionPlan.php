<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPlan extends JsonResource
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
          'id'                   => $this->id,
          'name'                 => $this->name,
          'description'          => $this->description,
          'active'               => $this->active,
          'auto_manage_delivery' => $this->auto_manage_delivery
        ];
    }
}
