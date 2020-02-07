<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalRequest extends JsonResource
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
          'amount'  => $this->amount,
          'user_id' => $this->user_id,
          'status'  => $this->status,
          'user'    => $this->user
        ];
    }
}

