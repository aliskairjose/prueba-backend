<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayuTransaction extends JsonResource
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
            'id'          => $this->id,
            'user_id'          => $this->user_id,
            'paymentmethod'        => $this->paymentmethod,
            'orderid'   => $this->orderid,
            'transactionid'        => $this->transactionid,
            'state'        => $this->state,
            'responsecode'        => $this->responsecode
        ];
    }
}
