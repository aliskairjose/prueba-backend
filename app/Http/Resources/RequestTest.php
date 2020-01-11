<?php

namespace App\Http\Resources;

use App\RequestTestDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestTest extends JsonResource
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
          'id'                => $this->id,
          'user_id'           => $this->user_id,
          'suplier_id'        => $this->suplier_id,
          'payment_method_id' => $this->payment_method_id,
          'status'            => $this->status,
          'total'             => $this->total,
          'detail'            => new RequestTestDetailCollection((RequestTestDetail::where('request_test_id', $this->id)->get()))
        ];
    }
}