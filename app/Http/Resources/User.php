<?php

namespace App\Http\Resources;

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
          'id'                => $this->id,
          'name'              => $this->name,
          'surname'           => $this->surname,
          'email'             => $this->email,
          'birthday'          => $this->birthday,
          'type_user'         => $this->type_user,
          'status'            => $this->status,
          'register_approved' => $this->register_approved,
          'approve_product'   => $this->approve_product,
          'banned'            => $this->banned,
          'role_id'           => $this->role_id,
          'products'          => new ProductCollection($this->products),
          'persistenceState'  => "Unchanged",
        ];
    }
}
