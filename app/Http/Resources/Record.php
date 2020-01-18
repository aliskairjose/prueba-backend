<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Record extends JsonResource
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
            'user_id'           => $this->user_id,
            'text_reference'    => $this->text_reference,
            'new_value'         => $this->new_value,
            'previous_value'    => $this->previous_value,
        ];
    }
}
