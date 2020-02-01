<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Landing extends Model
{
    use Notifiable;

    protected $fillable = ['user_id', ' product_id', ' url'];

    /**
     * Relacion musho a uno con producto
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
