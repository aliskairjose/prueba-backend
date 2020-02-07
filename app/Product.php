<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use Notifiable;

    /**
     *  The attributes thar are mass assignable
     *
     * @var array
     */
    protected $fillable = [
      'name',
      'description',
      'type',
      'stock',
      'sale_price',
      'suggested_price',
      'user_id',
      'privated_product',
      'active',
        'sku'
    ];

    /**
     * Método que define la relacion de uno a muchos con atributos
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * Método que deine la relacion de uno a muchos con variations
     */
    public function variations()
    {
        return $this->hasMany(Variation::class);

    }

    /**
     * Método que deine la relacion de uno a muchos con product photos
     */
    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    /**
     * Relacion mucho a muchos con Category
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Relacion uno a uno con Usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
