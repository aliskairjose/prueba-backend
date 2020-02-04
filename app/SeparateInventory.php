<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SeparateInventory extends Model
{
    use Notifiable;

    /**
     *  The attributes thar are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'suplier_id',
        'status',
        'quantity',
        'product_id',
        'variation_id'
    ];

}
