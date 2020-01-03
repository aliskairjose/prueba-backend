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
        'name', 'description', 'create_at', 'type', 'stock', 'sale_price', 'suggested_price', 'user_id',
    ];

}
