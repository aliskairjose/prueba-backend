<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Variation extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['suggested_price', 'sale_price', 'product_id', 'stock'];

    /**
     * Método que muestra la relacion muchos a muchos con Attributes
     */
    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }
}
