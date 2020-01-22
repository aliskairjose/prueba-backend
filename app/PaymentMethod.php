<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PaymentMethod extends Model
{
    use Notifiable;

    protected $fillable = [ 'name'];

    /**
     * Relacion Mucho a Muchos con Productos
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
