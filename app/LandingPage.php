<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LandingPage extends Model
{
    use Notifiable;

    protected $fillable = ['user_id', 'product_id', 'url'];

    /**
     * Relacion mucho a uno con producto
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
