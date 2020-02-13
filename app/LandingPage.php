<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Facades\JWTAuth;

class LandingPage extends Model
{
    use Notifiable;

    protected $fillable = ['user_id', 'product_id', 'url'];

    /**
     * Relacion mucho a uno con producto
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
