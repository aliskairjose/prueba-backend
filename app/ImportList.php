<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ImportList extends Model
{
    use Notifiable;

    /**
     *  The attributes thar are mass assignable
     *
     * @var array
     */
    protected $fillable = ['user_id', 'product_id', 'variation_id'];

    /**
     * Relacion uno a muchos con productos
     */
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
