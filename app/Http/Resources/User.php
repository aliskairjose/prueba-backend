<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'notes' => $this->notes,
            'photo' => $this->url,
            'type_user' => $this->role->name,
            'status' => $this->status,
            'register_approved' => $this->register_approved,
            'approve_product' => $this->approve_product,
            'banned' => $this->banned,
            'store_name' => $this->store_name,
            'store_url' => $this->store_url,
            'consumer_key' => $this->consumer_key,
            'consumer_secret' => $this->consumer_secret,
            'role_id' => $this->role_id,
            'role' => $this->role,
            'subscription_plan' => new SubscriptionPlan($this->plan),
            'products' => new ProductCollection($this->products),
            'wallet' => isset($this->wallet->amount) ? $this->wallet->amount : 0.00,
            'persistenceState' => "Unchanged",
        ];
    }
}
