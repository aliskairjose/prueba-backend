<?php

namespace App\Http\Resources;

use App\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'id'=> $this->id,
            'name'=> $this->name,
            'surname'=> $this->surname,
            'email'=> $this->email,
            'birthday'=> $this->birthday,
            'type_user'=> $this->type_user,
            'status'=> $this->status,
            'products'=> new ProductCollection(Product::where('user_id',$this->id)->get()),
            'persistenceState'=> "Unchanged",
        ];
    }
}
