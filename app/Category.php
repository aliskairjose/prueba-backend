<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use Notifiable;

    protected $fillable = [ 'name', 'parent_category'];

    /**
     * Relacion Mucho a Muchos con Productos
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
