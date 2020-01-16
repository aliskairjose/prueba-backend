<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MyOrderDetail extends Model
{
    use Notifiable;

    protected $fillable = [
        'my_order_id',
        'product_id',
        'variation_id',
        'quantity',
        'price'
    ];
}
